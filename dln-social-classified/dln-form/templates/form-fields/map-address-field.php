<?php 
wp_enqueue_script( 'dln-jquery-map-js', DLN_CLF_PLUGIN_URL . '/assets/3rd-party/jquery-ui-map/jquery.ui.map.js', array( 'jquery' ), '1.0.0', true );
wp_enqueue_script( 'dln-jquery-map-ext-js', DLN_CLF_PLUGIN_URL . '/assets/3rd-party/jquery-ui-map/jquery.ui.map.extensions.js', array( 'jquery' ), '1.0.0', true );
?>
<script type="text/javascript">
(function ($) {
	$(document).ready(function () {
		$('#map_canvas').gmap().bind('init', function(event, map) { 
			$(map).click( function(event) {
				$('#map_canvas').gmap('addMarker', {
					'position': event.latLng, 
					'draggable': true, 
					'bounds': false
				}, function(map, marker) {
					$('#dialog').append('<form id="dialog'+marker.__gm_id+'" method="get" action="/" style="display:none;"><p><label for="country">Country</label><input id="country'+marker.__gm_id+'" class="txt" name="country" value=""/></p><p><label for="state">State</label><input id="state'+marker.__gm_id+'" class="txt" name="state" value=""/></p><p><label for="address">Address</label><input id="address'+marker.__gm_id+'" class="txt" name="address" value=""/></p><p><label for="comment">Comment</label><textarea id="comment" class="txt" name="comment" cols="40" rows="5"></textarea></p></form>');
					findLocation(marker.getPosition(), marker);
				}).dragend( function(event) {
					findLocation(event.latLng, this);
				}).click( function() {
					openDialog(this);
				})
			});
		});

		function findLocation(location, marker) {
			$('#map_canvas').gmap('search', {'location': location}, function(results, status) {
				if ( status === 'OK' ) {
					$.each(results[0].address_components, function(i,v) {
						if ( v.types[0] == "administrative_area_level_1" || 
							 v.types[0] == "administrative_area_level_2" ) {
							$('#state'+marker.__gm_id).val(v.long_name);
						} else if ( v.types[0] == "country") {
							$('#country'+marker.__gm_id).val(v.long_name);
						}
					});
					marker.setTitle(results[0].formatted_address);
					$('#address'+marker.__gm_id).val(results[0].formatted_address);
					openDialog(marker);
				}
			});
		}

		function openDialog(marker) {
			$('#dialog'+marker.__gm_id).dialog({'modal':true, 'title': 'Edit and save point', 'buttons': { 
				"Remove": function() {
					$(this).dialog( "close" );
					marker.setMap(null);
				},
				"Save": function() {
					$(this).dialog( "close" );
				}
			}});
		}
	});
})(jQuery);

</script>

<div id="map_canvas" style="height: 200px;"></div>
