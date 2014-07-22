<?php
	wp_enqueue_script( 'dln-form-field-fs-category', DLN_CLF_PLUGIN_URL . '/dln-form/assets/js/fields/fs-category.js', array( 'jquery' ), '1.0.0', true );
	
	$categories = get_terms( 'product_cat', array( 'hide_empty' => false, 'order_by' => 'term_id' ) );
	if ( empty( $categories ) ) {
		new WP_Error( '500', __( 'Product Categories Not Found!', DLN_CLF ) );
		return;
	}
	$term_ids = array();
	
	$arr_colors = array( '#0099c2', '#ed5466', '#ffd25b', '#56cfe7', '#8ac448', '#6bccb4', '#55acee' );
	$count      = count( $arr_colors );
	
	$default_category = $default_tag = null;
?>
<div class="dln-selection-box-wrapper">
	<div class="dln-category-selection dln-selection-box">
		<div class="dln-selection-box-top">
		<?php foreach ( $categories as $i => $category ) {
			$term_ids[] = $category->term_id;
			$selected   = ( $i == 0 ) ? 'selected' : '';
			if ( $selected == 'selected' ) {
				$default_category = $category->term_id;
			}
			$icon_class = get_woocommerce_term_meta( $category->term_id, 'dln_icon_class', true );
			//$icon_color = get_woocommerce_term_meta( $category->term_id, 'dln_toggle_color', true );
			$icon_html  = ( $icon_class ) ? "<i class='{$icon_class}'></i>" : '';
			$icon_color = $arr_colors[( $i + 1 ) % $count];
		?>
			<a href="#" data-id="<?php echo $category->term_id ?>" class="dln-selection-box-item <?php echo $selected ?>" data-toggle-color="<?php echo $icon_color ?>">
				<div class="selection-box-item-content">
					<?php echo $icon_html ?>
			    	<div class="selection-box-item-icon"><?php echo $category->name?></div>
			  	</div>
			</a>
		<?php
		}?>
		</div>
	</div>
</div>
<div class="dln-selection-box-wrapper dln-selection-child">
	<div class="dln-category-selection dln-selection-box">
		<div class="dln-selection-box-top">
<?php 
	foreach ( $term_ids as $i => $id ) {
		$tag_ids = unserialize( get_woocommerce_term_meta( $id, 'dln_size_tags', true ) );
		if ( is_array( $tag_ids ) ) {
			$ids = array();
			foreach ( $tag_ids as $j => $tag ) {
				$ids[] = (int) $tag;
			}
			
			$terms = get_terms( 'fashion_size_tag', array( 'include' => $ids, 'hide_empty' => false ) );
			foreach ( $terms as $i => $term ) {
				?>
				<a href="#" data-parent-id="<?php echo $id ?>" data-id="<?php echo $term->term_id ?>" class="dln-selection-box-item dln-selection-sub-item">
					<div class="selection-box-item-content">
				    	<div class="selection-box-item-icon"><?php echo $term->name ?></div>
				    	<p class="help-block"><?php echo $term->description ?></p>
				  	</div>
				</a>
				<?php
			}
		}
	}
?>
		</div>
	</div>
</div>
<input type="hidden" name="dln_fs_category" id="dln_fs_category" value="" />
<input type="hidden" name="dln_fs_tag_sizes" id="dln_fs_tag_sizes" value="" />