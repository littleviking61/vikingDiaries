(function( root, $, undefined ) {
	"use strict";

	var $grid, lastPage;

	$(function () {
		// DOM ready, take it away
		// init Isotope
		
		$grid = $('.dairies').isotope({
			sortBy : 'date',
			sortAscending: false,

			getSortData: {
				date: '[data-date]'
			},

			masonry: {
			  columnWidth: 'article',
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
		      loadArticle(url);
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

	});

	function loadArticle(url) {
    $.ajax({
      url    : url,
      type   : 'POST',
      headers: {
          'X-Requested-With':'BAWXMLHttpRequest'
      }
    }).done( function( data ) {
      $grid.isotope( 'insert', $(data).filter('article') );
      init_actions($grid);
      history.pushState(document.title, 'next', url);
      $('.pagination .loading').removeClass('loading').removeClass('error');
    }).error( function() {
    	$('.pagination .loading').removeClass('loading').addClass('error');
    });
	}

	function init_actions(container) {
		container = container || $('main');

		$(".oEmbed", container).fitVids();

		fotoramaLightbox(container);
		popupInit(container);

		container.imagesLoaded().progress( function() {
		  $grid.isotope('layout');
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