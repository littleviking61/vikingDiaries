(function( root, $, undefined ) {
	"use strict";

	var $grid, lastPage, dairies, taille;

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
		      loadPagedArticle(url);
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

		$(document).on('click', '.ajax-go', function(e) {
			e.preventDefault();
			var target = $(this).closest('.post');

			if(target.hasClass('open')) {
				closeArticle(target, true);
			}else{
				// check open
				var open = $('.post.open');
				if(open.length > 0) closeArticle(open);
				// load article
				loadArticle($(this).attr('href'), target);
			}
		});

		$(document).on('click', '.post .mfp-close', function(e) {
			e.preventDefault();
			var target = $(this).closest('.post');
			closeArticle(target, true);
		});

		window.addEventListener('popstate', function(event) {
		  urlChange(event);

		 // updateContent(event.state);
		});

	});

	function urlChange(event) {
		console.log(event);
	}

	function closeArticle(target, scroll) {
		target.removeClass('open');
		init_actions(target, scroll);
		// window.history.go(-1);
	}

	function loadArticle(url, target) {

		if($('.complete' ,target).length < 1) {
			target.addClass('loading');

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
	      // history.pushState(document.title, 'next', url);
	    }).error( function() {
	    	target.removeClass('loading').addClass('error');
	    });
		}else{
			target.addClass('open');
			init_actions(target, true);
			// history.pushState(document.title, 'next', url);
		}
	}

	// load more page
	function loadPagedArticle(url) {
    $.ajax({
      url    : url,
      type   : 'POST',
      headers: {
          'X-Requested-With':'BAWXMLHttpRequest'
      }
    }).done( function( data ) {
      $grid.isotope( 'insert', $(data).filter('article') );
      init_actions($grid);
      // history.pushState(document.title, 'next', url);
      $('.pagination .loading').removeClass('loading').removeClass('error');
    }).error( function() {
    	$('.pagination .loading').removeClass('loading').addClass('error');
    });
	}

	function init_actions(container, scroll) {
		container = container || $('main');

		$(".oEmbed", container).fitVids();

		fotoramaLightbox(container);
		popupInit(container);

		container.imagesLoaded().progress( function() {
		  $grid.isotope('layout');
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

} ( this, jQuery ));