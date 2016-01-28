(function( root, $, undefined ) {
	"use strict";

	var $grid, lastPage, dairies, taille, initialUrl, moveByHistoty = false;

	$(function () {
		// DOM ready, take it away
		// init Isotope
		dairies = $('.dairies');
		$grid = dairies.isotope({
			sortBy : 'date',
			sortAscending: false,

			getSortData: {
				date: '[data-date]'
			},

			masonry: {
			  columnWidth: (dairies.width() / 2) - 30,
			  gutter: 60
			}

		});

		// layout Isotope after each image loads
		$grid.imagesLoaded().progress( function() {
		  $grid.isotope('layout');
		});

		init_actions();

		lastPage = $('.pagination-links .current');
		
		$(document).on( 'click', '.pagination .more', function(e){
			e.preventDefault();

			$(this).addClass('loading');

			if($(this).hasClass('next')){
		    lastPage = lastPage.nextAll('a:not(.loaded)').first();
			}else{
		    lastPage = lastPage.prevAll('a:not(.loaded)').first();
			}

	    if(!lastPage.hasClass('next') && !lastPage.hasClass('prev')) {
		    var url = lastPage.attr( 'href');
				if(url !== undefined) {
					lastPage.addClass('loaded');
		      loadPagedArticle(url, lastPage);
				}
				// check si supprimer bouton
				if($(this).hasClass('next')){
			    if(lastPage.next().hasClass('next')) $(this).addClass('disable');
				}else{
			    if(lastPage.prev().hasClass('prev')) $(this).addClass('disable');
				}

		  }else{
		  	$(this).addClass('disable');
		  }
		});

		dairies.on('click', '.ajax-go, .post .more-link', function(e) {
			e.preventDefault();
			var target = $(this).closest('.post');

			if(target.hasClass('open') && !moveByHistoty) {
				closeArticle(target, true);
			}else{
				// check open
				var open = $('.post.open', dairies);
				if(open.length > 0) closeArticle(open, false, true);
				// load article
				loadArticle($(this).attr('href'), target);
			}
		});

		dairies.on('click', '.post .mfp-close', function(e) {
			e.preventDefault();
			var target = $(this).closest('.post');
			closeArticle(target, true);
		});

		// close article on esc
		$(document).keyup(function(e){
			if(e.keyCode === 27) {
				var open = $('.post.open', dairies);
				if(open.length > 0) closeArticle(open, true);
			}
		});

		window.addEventListener('popstate', function(event) {
			urlChange(event);
		});

		initialUrl = location.href;
		history.replaceState({initial: true}, 'Initial', initialUrl);

	});

  // Back off, browser, I got this...
	if ('scrollRestoration' in history) {
	  history.scrollRestoration = 'manual';
	}

	function urlChange(event) {
		if(event.isTrusted) {

			var currentState = history.state;
			if(typeof currentState == 'object') {
				
				if(typeof currentState.article == 'string') {
					moveByHistoty = true;
					$(currentState.article + ' .entry-title .ajax-go', dairies).trigger('click');
					moveByHistoty = false;
				}

				if(typeof currentState.initial == 'boolean' || typeof currentState.page == 'string') {
					// check open
					var open = $('.post.open', dairies);
					if(open.length > 0) closeArticle(open, false, true);
				}
			}

		}
	}

	function init_actions(container, scroll) {
		container = container || $('main');

		$('.oEmbed, .entry-content iframe[src*="=oembed"]', container).fitVids();

		fotoramaLightbox(container);
		popupInit(container);
		commentInit(container);	

		container.imagesLoaded().progress( function() {
		  $grid.isotope('layout');
			dairies.removeClass('loading');
		});

		$grid.one( 'layoutComplete', function() {
			if(scroll) $(window).scrollTo(container.offset().top-70, 400);
		});
	}

	function fotoramaLightbox(container) {

		$('.gallery', container).not('.fotorama')
		 .on('fotorama:fullscreenenter', function (e, fotorama, extra) {
			 	fotorama.setOptions({
				  margin: 10,
				  thumbmargin: 10
				});
      })
		 .on('fotorama:fullscreenexit', function (e, fotorama, extra) {
			 	fotorama.setOptions({
				  margin: 2,
				  thumbmargin: 2
				});
      })
			.fotorama({
				width: '100%',
				maxwidth: '100%',
			  ratio: 3/2,
			  allowfullscreen: true,
			  nav: 'thumbs',
			  thumbborderwidth: 0,
			  fit: 'cover',
			}).children().addClass('fotorama__wrap--no-controls');

		$('a[href="#view-position"]', container).magnificPopup({
			type: 'ajax',
			ajax: {
				settings: {
					url: '/wp-admin/admin-ajax.php',
					type: 'post'

				}
			},
			callbacks: {
				elementParse: function() {
					this.st.ajax.settings.data = {
						action: 'get_position',
					};
				},
				ajaxContentAdded: function() {
					// Ajax content is loaded and appended to DOM
					$modal = this.content;

				},
				open: function() {
    				ga('send', 'event', 'ajax', 'click', 'position', this.currItem.el[0].title);
				}
			}
		});

		$(window).trigger('resize');
	} 

	// magnifying popup
	function popupInit(container) {
    $('.popup-youtube, .popup-vimeo, .popup-gmaps', container).magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: true,

      fixedContentPos: false,

      callbacks: {
    		open: function() {
    			ga('send', 'event', 'iframe', 'click', 'popup a', this.currItem.src);
				}
			}
    });

	  $('.simple-ajax-popup', container).magnificPopup({
	    type: 'ajax',
      alignTop: true,
      overflowY: 'scroll',
      closeOnBgClick: true,
	    tError: '<a href="%url%">The content</a> could not be loaded.',
	    callbacks: {
				ajaxContentAdded: function(data) {
  				ga('send', 'event', 'ajax', 'click', 'simple', this.currItem.el[0].title);
					fotoramaLightbox(this.container);
				},
				elementParse: function() {
					this.st.ajax.settings = {
						headers: { 'X-Requested-With':'BAWXMLHttpRequest' },
					};
				},
			}
	  });
    
	}

	function commentInit(container) {
		var 
			commentform = $('#commentform', container), // find the comment form
			statusdiv = $('<div id="comment-status" ></div>').prependTo(commentform); // add info panel before the form to provide feedback or errors

		commentform.submit(function(){
		    //serialize and store form data in a variable
		    var formdata = commentform.serialize();
		    //Add a status message
		    statusdiv.html('<p>Processing...</p>');
		    //Extract action URL from commentform
		    var formurl = commentform.attr('action');
		    //Post Form with data
		    $.ajax({
		        type: 'post',
		        url: formurl,
		        data: formdata,
		        error: function(XMLHttpRequest, textStatus, errorThrown)
	            {
	                statusdiv.html('<p class="ajax-error" >Vous avez peut-être laisser l\'un des éléments requis vide, ou vous posté trop rapidement</p>');
	            },
		        success: function(data, textStatus){
	            if(data == "success" || textStatus == "success"){
	                statusdiv.html('<p class="ajax-success" >Merci pour votre commentaire, il sera approuvé rapidement.</p>');
	            }else{
	                statusdiv.html('<p class="ajax-error" >Veuillez attendre un petit peu avant de poster votre réponse</p>');
	                commentform.find('textarea[name=comment]').val('');
	            }
		        }
		    });
		    return false;
		});
	}

		// load more page
	function loadPagedArticle(url, lastPage) {
    $.ajax({
      url    : url,
      type   : 'POST',
      headers: {
          'X-Requested-With':'BAWXMLHttpRequest'
      }
    }).done( function( data ) {
      $grid.isotope( 'insert', $(data).filter('article') );
      init_actions($grid);
      // push state hisoty
      if(!moveByHistoty) history.pushState({page: url}, 'Page ' + lastPage.text(), url);
      $('.pagination .loading').removeClass('loading').removeClass('error');
    }).error( function() {
    	$('.pagination .loading').removeClass('loading').addClass('error');
    });
	}

	// load single ajax
	function loadArticle(url, target) {
		
		if($('.complete' ,target).length < 1) {
			target.addClass('loading');
			dairies.addClass('loading');

			$grid.isotope('layout');
			$grid.one( 'layoutComplete', function() { $(window).scrollTo(target.offset().top-70, 400); });

			$.ajax({
	      url    : url,
	      type   : 'POST',
	      headers: {
	          'X-Requested-With':'BAWXMLHttpRequest'
	      }
	    }).done( function( data ) {
				target.addClass('open');

	    	target.append(data);
	     	target.removeClass('loading').removeClass('error');

	    	init_actions(target, true);
	    	// change URL
	      if(!moveByHistoty) history.pushState({article: '#'+target.attr('id')}, 'Article' + target.attr('id'), url);
	    }).error( function() {
	    	target.removeClass('loading').addClass('error');
	    });
		}else{
			target.addClass('open');
			init_actions(target, true);
			// change URL
			if(!moveByHistoty) history.pushState({article: '#'+target.attr('id')}, 'Article' + target.attr('id'), url);
		}
	}

	// close single
	function closeArticle(target, scroll, nochange) {
		target.removeClass('open');
		init_actions(target, scroll);
		// came back to page state
		if(!moveByHistoty && !nochange) {
			var url = lastPage.attr('href') || initialUrl;
			history.pushState({page: url}, 'Page ' + lastPage.text(), url);
		}
	}

} ( this, jQuery ));