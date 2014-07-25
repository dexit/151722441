<?php 
	$fs_colors = get_terms( 'dln_fs_color', array( 'hide_empty' => false, 'order_by' => 'term_id' ) );
	if ( empty( $fs_colors ) ) {
		new WP_Error( '500', __( 'Product List Colors Not Found!', DLN_CLF ) );
		return;
	}
?>
<div class="dln-selection-box-wrapper dln-selection-child">
	<div class="dln-category-selection dln-selection-box">
		<div class="dln-selection-box-top">
<?php 
	foreach ( $fs_colors as $i => $color ) {
		$color_value = unserialize( get_woocommerce_term_meta( $color->term_id, 'dln_fs_color_value', true ) );
		if ( $color_value ) {
		?>
		<a href="#" data-parent-id="<?php echo $color->term_id ?>" data-id="<?php echo $color->term_id ?>" class="dln-selection-sub-item">
			<div class="selection-box-item-content">
		    	<div class="selection-box-item-icon"><?php echo $color->name ?></div>
		    	<p class="help-block"><?php echo $color->description ?></p>
		  	</div>
		</a>
		<?php
		}
	}
?>
		</div>
	</div>
</div>