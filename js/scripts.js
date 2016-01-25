(function( root, $, undefined ) {
	"use strict";

	$(function () {
		// DOM ready, take it away
		// init Isotope
		// 
		var $grid = $('.dairies').isotope({
			masonry: {
			  columnWidth: 'article',
			  gutter: 60
			}

		});
		// layout Isotope after each image loads
		$grid.imagesLoaded().progress( function() {
		  $grid.isotope('layout');
		});

		$(".oEmbed").fitVids();

		fotoramaLightbox();
		popupInit();
	});

	function fotoramaLightbox() {

		$('.gallery').not('.fotorama')
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

		// $('<style></style>').appendTo($(document.body)).remove();
		// 
		$('a[href="#view-gallery"]').magnificPopup({
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
						action: 'get_gallery',
						gallery: this.st.el.attr('data-ids'),
						index: '0'
					};
				},
				ajaxContentAdded: function() {
					// Ajax content is loaded and appended to DOM
					$modal = this.content;

					$('.fotorama-ajax', $modal).fotorama({
						height: this.container.height() - 140,
					  width: '100%',
						maxwidth: '100%',
					  ratio: 3/2,
					  nav: 'thumbs',
					  thumbborderwidth: 0,
					  fit: 'scaledown',
					  margin: 10,
			  		thumbmargin: 10
					});
				},
				open: function() {
    			ga('send', 'event', 'ajax', 'click', 'gallery', this.currItem.el[0].title);
				}
			}
		});

		$('a[href="#view-position"]').magnificPopup({
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
					console.log($modal);

				},
				open: function() {
    				ga('send', 'event', 'ajax', 'click', 'position', this.currItem.el[0].title);
				}
			}
		});
	} 

	// magnifying popup
	function popupInit() {
    $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
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

	  $('.simple-ajax-popup').magnificPopup({
	    type: 'ajax',
	    tError: '<a href="%url%">The content</a> could not be loaded.',
	    callbacks: {
	    	open: function() {
	  			ga('send', 'event', 'ajax', 'click', 'simple', this.currItem.el[0].title);
				}
			}
	  });
    
	}

} ( this, jQuery ));