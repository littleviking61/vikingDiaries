<?php 
	global $wpdb;
	$acfPoints = $wpdb->get_results( 'SELECT * FROM wp_messagespot ORDER BY ID DESC ', OBJECT ); ?>

<div class="acf-map">
	<?php foreach ($acfPoints as $point) :?>
		<span class="marker" data-lat="<?= $point->latitude ?>" data-lng="<?= $point->longitude ?>"></span>
	<?php endforeach; ?>
</div>
<style>
	.acf-map{
		height: <?=  $heightMap  ?>;	
		overflow: hidden;
		width: 100%;
		z-index: 4;
	}
</style>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
(function($) {

/*
*  render_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;   
var carte = $('.acf-map'); 	

function render_map( $el ) {

	// var
	var $markers = $el.find('.marker');

	// vars
	var args = {
		zoom		: 8,
		center		: new google.maps.LatLng(0, 0),
		scrollwheel: false,
		mapTypeId	: google.maps.MapTypeId.HYBRID,
	  // mapTypeControl: false,
    panControl: true,
    panControlOptions: {
        position: google.maps.ControlPosition.LEFT_CENTER
    },
    zoomControl: true,
    zoomControlOptions: {
        position: google.maps.ControlPosition.LEFT_CENTER
    },
    scaleControl: true,  // fixed to BOTTOM_RIGHT
    streetViewControl: false,
    // streetViewControlOptions: {
    //     position: google.maps.ControlPosition.LEFT_CENTER
    // },
	};

	// create map	
	// directionsDisplay = new google.maps.DirectionsRenderer();
	map = new google.maps.Map( $el[0], args);
	// directionsDisplay.setMap(map);

	// add a markers reference
	map.markers = [];

	// Define a symbol using SVG path notation, with an opacity of 1.
	 var lineSymbol = {
	   path: 'M 0,-1 0,1',
	   strokeOpacity: 1,
     strokeColor: 'white',
	   scale: 3
	 }

	poly = new google.maps.Polyline({
	    strokeOpacity: 1,
	    strokeColor: '#B76C34',
	    strokeWeight: 10,
      icons: [{
        icon: lineSymbol,
        offset: '0',
        repeat: '12px'
      }],
  });
  poly.setMap(map);

	// add markers
	$markers.each(function(index){
			if($(this).data('icon') !== undefined) add_marker( $(this), map, $(this).data('icon'));
    	else add_marker( $(this), map);
	});

	// center map
	center_map( map );
	// if(locations !== undefined) calcRoute();
	google.maps.event.addListenerOnce(map, 'idle', function(){
	    carte.addClass('active');
	});
}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker( $marker, map, markerIcon) {
	var path = poly.getPath();

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
	path.push(latlng);

	// if(markerIcon !== undefined) {
		// console.log('oui');
		// create marker
		// var image = markerIcon;
		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map,
			// icon: markerIcon
		});

		// add to array
		map.markers.push( marker );

		// if marker contains HTML, add it to an infoWindow
		// if( $marker.html() )
		// {
		// 	// create info window
		// 	var infowindow = new google.maps.InfoWindow({
		// 		content		: $marker.html()
		// 	});

		// 	// show info window when marker is clicked
		// 	google.maps.event.addListener(marker, 'click', function() {

		// 		infowindow.open( map, marker );

		// 	});
		// }
	// }

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map( map ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}

}

$(document).ready(function(){

	$('.acf-map').each(function(){
		render_map( $(this) );

	});

});

})(jQuery);
</script>