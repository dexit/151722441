<?php 
if ( ! empty ( $field['value'] ) ) {
	echo balanceTags( do_shortcode( $field['value'] ) );
}
?>