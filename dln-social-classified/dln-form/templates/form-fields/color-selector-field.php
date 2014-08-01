<?php 
	wp_enqueue_script( 'dln-form-field-color-selector', DLN_CLF_PLUGIN_URL . '/assets/js/fields/color-selector.js', array( 'jquery' ), '1.0.0', true );
	
	$fs_colors = get_terms( 'dln_fs_color', array( 'hide_empty' => false, 'order_by' => 'name' ) );
if ( empty( $fs_colors ) ) {
	$result = new WP_Error( '500', __( 'Product List Colors Not Found!', DLN_CLF ) );
	return $result;
}
?>
<div class="dln-selection-box-wrapper">
	<div class="dln-category-selection dln-selection-box">
		<div class="dln-selection-box-top">
<?php 
foreach ( $fs_colors as $i => $color ) {
	$color_value = get_woocommerce_term_meta( $color->term_id, 'dln_fs_color_value', true );
	if ( $color_value ) {
		?>
		<a href="#" data-toggle-color="<?php echo esc_attr( $color_value ) ?>" data-id="<?php echo esc_attr( $color->term_id ) ?>" class="dln-fs-color-item">
			<i class="dln-fs-color-ico" style="background-color: <?php echo esc_attr( $color_value ) ?>"></i>
	    	<span class="dln-fs-color-ico-name"><?php echo esc_html( $color->name ) ?></span>
		</a>
		<?php
	}
}
?>
		</div>
	</div>
</div>
<input type="hidden" id="dln_fs_color_selected" name="dln_fs_color_selected" value="" />