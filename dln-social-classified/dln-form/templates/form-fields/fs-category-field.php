<?php 
	$categories = get_terms( 'product_cat', array( 'hide_empty' => 'true', 'order_by' => 'name' ) );
	if ( empty( $categories ) ) {
		new WP_Error( '500', __( 'Product Categories Not Found!', DLN_CLF ) );
		return;
	}
	$term_ids = array();
?>
<div class="dln-selection-box-wrapper">
	<div class="dln-category-selection dln-selection-box">
		<div class="dln-selection-box-top">
		<?php foreach ( $categories as $i => $category ) {
			$term_ids[] = $category->term_id;
			$selected   = ( $i == 0 ) ? 'selected' : '';
			$icon_class = get_woocommerce_term_meta( $category->term_id, 'dln_icon_class', true );
			$icon_html  = ( $icon_class ) ? "<i class='{$icon_class}'></i>" : '';
		?>
			<div data-id="<?php echo $category->term_id ?>" class="dln-selection-box-item <?php echo $selected ?>">
				<div class="selection-box-item-content">
					<?php echo $icon_html ?>
			    	<div class="selection-box-item-icon"><?php echo $category->name?></div>
			  	</div>
			</div>
		<?php
		}?>
		</div>
	</div>
</div>

<div class="dln-selection-box-wrapper">
	<div class="dln-category-selection dln-selection-box">
		<div class="dln-selection-box-top">
<?php 
	foreach ( $term_ids as $i => $id ) {
		?>
		
		<?php
	}
?>
		</div>
	</div>
</div>
<input type="hidden" name="dln_fs_category" id="dln_fs_category" value="" />
<input type="hidden" name="dln_fs_tag_sizes" id="dln_fs_tag_sizes" value="" />