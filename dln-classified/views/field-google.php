<?php
if (! defined ( 'ABS_PATH' )) exit ( 'ABS_PATH is not loaded. Direct access is not allowed.' );

$item    = osc_item();
$address = ( isset( $item['s_address'] ) ) ? $item['s_address'] : '';
$lat     = ( isset( $item['d_coord_lat'] ) ) ? $item['d_coord_lat'] : '';
$long    = ( isset( $item['d_coord_long'] ) ) ? $item['d_coord_long'] : '';
?>

<div class="form-group control-group">
	<label for="dln_address" class="col-sm-2 control-label">Address</label>
	<div class="col-sm-10 controls">
		<input class="form-control" id="dln_address" name="dln_address" type="text" value="<?php echo $address ?>"/>
	</div>
</div>

<div id="dln_field_google" style="height: 300px; width: 100%"></div>
<input type="hidden" id="dln_lat" name="dln_lat" value="<?php echo $lat ?>" />
<input type="hidden" id="dln_long" name="dln_long" value="<?php echo $long ?>" />

<script
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places">
</script>

<script type="text/javascript"> 
var map;
var marker;
var lat        = $('#dln_lat').val();
var lng        = $('#dln_long').val();
var myLatlng   = '';
if ( lat && lng ) {
	myLatlng = new google.maps.LatLng( lat, lng );
} else {
	myLatlng = new google.maps.LatLng(21.033333,105.85000000000000); 
}
var geocoder   = new google.maps.Geocoder();
var infowindow = new google.maps.InfoWindow();
var autocomplete = null;

function initialize(){
	var mapOptions = {
		zoom: 15,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById("dln_field_google"), mapOptions);
	
	marker = new google.maps.Marker({
		map: map,
		position: myLatlng,
		draggable: true 
	});
	
	/*geocoder.geocode({'latLng': myLatlng }, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				setAddressField( results[0].formatted_address, marker, map );
			}
		}
	});*/
	
	google.maps.event.addListener(marker, 'dragend', function() {
		
		geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
			
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					setAddressField( results[0].formatted_address, marker, map );
				}
			}
		});
	});

	// Add autocomplete to text-field
	autocomplete = new google.maps.places.Autocomplete( (document.getElementById('dln_address')), { types: ['geocode'] } );
	
	google.maps.event.addListener(autocomplete, 'place_changed', function () {
		var place = autocomplete.getPlace();
		
		// Set view port
		if ( place && place.geometry ) {
			if ( place.geometry.viewport ) {
				map.fitBounds( place.geometry.viewport );
			} else {
				map.setCenter(place.geometry.location);
			}

			// Set marker
			marker.setPosition(place.geometry.location);

			setAddressField( place.formatted_address, marker, map );
		}
	});

	// Prevent enter key
	$('#dln_address').keypress(function(event) {
	    if (event.keyCode == 13) {
	        event.preventDefault();
	    }
	});
}
google.maps.event.addDomListener(window, 'load', initialize);

function setAddressField( address, marker, map ) {
	if ( address ) {
		$('#dln_address').val(address);
		infowindow.setContent(address);
	}

	if ( map && marker ) {
		$('#dln_lat').val(marker.getPosition().lat());
		$('#dln_long').val(marker.getPosition().lng());
		infowindow.open(map, marker);
	}
}

function geolocate() {
	if ( autocomplete ) {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
			    var geolocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
			});
		}
	}
}
</script>
