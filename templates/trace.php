<?php 
global $wpdb;

$locationsAll = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}messagespot WHERE messageType ='OK' ORDER BY id DESC ");

if(count($locationsAll) > 0): ?>

	<div class="full-content">
		<div class="acf-map">
			<?php foreach ($locationsAll as $location): ?>
				<div class="marker" data-lat="<?= $location->latitude; ?>" data-lng="<?= $location->longitude; ?>">
					<h4><?= date('c', $location->unixTime) ?></h4>
				</div>
			<?php endforeach ?>
		</div>
	</div>

<?php endif; ?>

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

function render_map( $el ) {

	// var
	var $markers = $el.find('.marker');

	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		scrollwheel: false,
		mapTypeId	: google.maps.MapTypeId.ROADMAP,
	  mapTypeControl: false,
    panControl: true,
    panControlOptions: {
        position: google.maps.ControlPosition.LEFT_CENTER
    },
    zoomControl: true,
    zoomControlOptions: {
        position: google.maps.ControlPosition.LEFT_CENTER
    },
    scaleControl: true,  // fixed to BOTTOM_RIGHT
    streetViewControl: true,
    streetViewControlOptions: {
        position: google.maps.ControlPosition.LEFT_CENTER
    },
	};

	// create map	
	directionsDisplay = new google.maps.DirectionsRenderer();
	map = new google.maps.Map( $el[0], args);
	directionsDisplay.setMap(map);

	// add a markers reference
	map.markers = [];

	// add markers
	$markers.each(function(){

    	add_marker( $(this), map );

	});

	// center map
	center_map( map );
	// console.log(locations);
	// if(locations !== undefined) calcRoute();
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

function add_marker( $marker, map ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

	// create marker
	var marker = new google.maps.Marker({
		position	: latlng,
		map			: map
	});

	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});

		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {

			infowindow.open( map, marker );

		});
	}

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

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/

function calcRoute() {
	nbPoint = locations.length-1;

  var waypoints = [];
 	$.each(locations, function(index, value){
 		waypoints.push( {location:locations[index].address} );
 	});

  var start = waypoints.shift().location;
  var end = waypoints.pop().location;
  // console.log(start, end, waypoints);

  var request = {
    origin: start,
	  destination: end,
	  waypoints: waypoints,
    travelMode: google.maps.TravelMode.DRIVING,
    // waypoints: waypoints
  };
  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(result);
    }
    var totalDistance = 0;
		var totalDuration = 0;
		var legs = result.routes[0].legs;
		for(var i=0; i<legs.length; ++i) {
		    totalDistance += legs[i].distance.value;
		    totalDuration += legs[i].duration.value;
		}

		$('#map-result').html(Math.round(totalDistance / 1000) + ' km soit ' + Math.round( totalDuration / 60 / 60) + ' heure de route' );
  });
}

$(document).ready(function(){

	$('.acf-map').each(function(){

		render_map( $(this) );

	});

});

})(jQuery);
</script>