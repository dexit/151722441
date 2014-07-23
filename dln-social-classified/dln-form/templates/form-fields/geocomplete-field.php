<?php
wp_enqueue_script( 'dln-google-map-lib-js', 'http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&language=vi' );
wp_enqueue_script( 'dln-jquery-geocomplete-js', DLN_CLF_PLUGIN_URL . '/assets/3rd-party/jquery-geocomplete/jquery.geocomplete.js', array( 'jquery' ), '1.0.0', true );
wp_enqueue_script( 'dln-geocomplete-js', DLN_CLF_PLUGIN_URL . '/dln-form/assets/js/fields/geocomplete.js', array( 'jquery' ), '1.0.0', true );
?>
<form>
<div class="input-group">
	<input id="dln_geocomplete" name="dln_geocomplete" class="form-control" type="text" placeholder="<?php _e( 'Type in an address', DLN_CLF ) ?>" value="Hà Noi, Hanoi, Vietnam" />
	<span class="input-group-btn">
		<button id="dln_find_current" class="btn btn-default" type="button" title="<?php _e( 'Current Position', DLN_CLF ) ?>"><i class="ico-location"></i></button>
		<button id="dln_find_address" class="btn btn-default" type="button" title="<?php _e( 'Find Address', DLN_CLF ) ?>"><i class="ico-search3"></i></button>
	</span>
</div>
<div class="dln_map_canvas" style="height: 200px;"></div>
<input type="hidden" id="dln_fs_lat" name="dln_fs_lat" value="" />
<input type="hidden" id="dln_fs_lng" name="dln_fs_lng" value="" />
</form>