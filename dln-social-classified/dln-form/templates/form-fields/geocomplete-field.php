<?php
wp_enqueue_script( 'dln-jquery-geocomplete-js', DLN_CLF_PLUGIN_URL . '/assets/3rd-party/jquery-geocomplete/jquery.geocomplete.js', array( 'jquery' ), '1.0.0', true );
?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script>
(function ($) {
	$(document).ready(function () {
		var dln_geo = $("#geocomplete").geocomplete({
			map: ".map_canvas",
			details: "form ",
			markerOptions: {
				draggable: true
	       	}
		});
	        
		$("#geocomplete").bind("geocode:dragged", function(event, latLng){
			var geocoder      = new google.maps.Geocoder();
			var request       = {};
			request['latLng'] = latLng;
			geocoder.geocode( request, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					var result = results[0];
			        $('#geocomplete').val(result.formatted_address);
				}	 
			} );
			$("input[name=lat]").val(latLng.lat());
			$("input[name=lng]").val(latLng.lng());
			$("#reset").show();
		});
	        
		$("#reset").click(function(){
			$("#geocomplete").geocomplete("resetMarker");
			$("#reset").hide();
			return false;
		});
	        
		$("#find").click(function(){
			$("#geocomplete").trigger("geocode");
		}).click();
	});
})(jQuery);
</script>
 
<form>
	<input id="geocomplete" type="text" placeholder="Type in an address" value="111 Broadway, New York, NY" />
	<input id="find" type="button" value="find" />

	<div class="map_canvas" style="height: 200px;"></div>

	<fieldset>
		<label>Latitude</label>
		<input name="lat" type="text" value="">

		<label>Longitude</label>
		<input name="lng" type="text" value="">

		<label>Formatted Address</label>
		<input name="formatted_address" type="text" value="">
	</fieldset>

	<a id="reset" href="#" style="display:none;">Reset Marker</a>
</form>