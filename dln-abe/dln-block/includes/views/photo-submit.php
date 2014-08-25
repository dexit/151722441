<?php

if ( ! defined( 'WPINC' ) ) { die; }

// Array of defined attribute taxonomies
$attribute_taxonomies = wc_get_attribute_taxonomies();

if ( $attribute_taxonomies ) {
	foreach ( $attribute_taxonomies as $tax ) {
		// Get name of taxonomy we're now outputting (pa_xxx)
		$attribute_taxonomy_name = wc_attribute_taxonomy_name( $tax->attribute_name );
		
		// Ensure it exists
		if ( ! taxonomy_exists( $attribute_taxonomy_name ) )
			continue;
		
		if ( $tax->attribute_type == "select" ) {

			$all_terms = get_terms( $attribute_taxonomy_name, 'orderby=name&hide_empty=0' );
			if ( $all_terms ) {
				foreach ( $all_terms as $term ) {
					$has_term = has_term( (int) $term->term_id, $attribute_taxonomy_name, $thepostid ) ? 1 : 0;
					echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( $has_term, 1, false ) . '>' . $term->name . '</option>';
				}
			} elseif ( $tax->attribute_type == "text" ) {
				// Text attributes should list terms pipe separated
				if ( $post_terms ) {
					$values = array();
					foreach ( $post_terms as $term )
						$values[] = $term->name;
					echo esc_attr( implode( ' ' . WC_DELIMITER . ' ', $values ) );
				}
			}
			
		}
	}
}
?>

<input type="text" name="attribute_values[<?php echo $i; ?>]" value="<?php

	// Text attributes should list terms pipe separated
	if ( $post_terms ) {
		$values = array();
		foreach ( $post_terms as $term )
			$values[] = $term->name;
		echo esc_attr( implode( ' ' . WC_DELIMITER . ' ', $values ) );
	}

?>" placeholder="<?php _e( 'Pipe (|) separate terms', 'woocommerce' ); ?>" />

<div id="dln_modal_select_photo" class="modal fade dln-modal-resize">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h3 class="semibold modal-title text-primary"><?php _e( 'Select Photo', DLN_ABE ) ?></h3>
			</div>
			<div class="modal-body">
				<!-- Modal content here! -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e( 'Close', DLN_ABE ) ?></button>
				<button type="button" class="btn btn-primary dln-select"><?php _e( 'Select photo', DLN_ABE ) ?></button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="panel panel-default overflow-hidden">
	<div class="panel-heading">
		<h5 class="panel-title">Basic example</h5>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<legend><?php _e( 'Item Settings', DLN_ABE ) ?></legend>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<div id="dln_add_status"
								class="thumbnail thumbnail-album dln-items">
								<!-- media -->
								<div class="media">
									<!--/ indicator -->
									<!-- toolbar overlay -->
									<div id="dln_select_image" class="overlay show">
										<div class="toolbar dln-toolbar">
											<a href="javascript:void(0);" class="btn btn-default" title="upload to collection">
												<i class="ico-picture"></i>
											</a>
										</div>
									</div>
									<!--/ toolbar overlay -->
								</div>
								<!--/ media -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<legend><?php _e( 'Item Settings', DLN_ABE ) ?></legend>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<?php echo balanceTags( DLN_Block_Photo_Submit::get_field( 'basic', 'photobabe_desc' ) ) ?>
						</div>
					</div>
				</div>
				
				<div class="form-group dln-field-meta">
					<div class="row">
						<div class="col-sm-12"><label class="control-label"><?php _e( 'Fields', DLN_CLF ) ?> </label></div>
					</div>
					<div id="dln_field_meta_block">
						<div class="row">
							<div class="col-xs-4">
								<select class="form-control dln-field-meta-key dln-selectize-create" placeholder="<?php _e( 'Select Attribute', DLN_CLF ) ?>">
								</select>
							</div>
							<div class="col-xs-6">
								<input type="text" value="" class="form-control dln-field-meta-value" placeholder="<?php _e( 'Attribute Value', DLN_CLF ) ?>" />
							</div>
							<div class="col-xs-2">
								<a class="dln-field-close btn btn-default">X</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<div class="btn-group" id="dln_post_perm">
								<button type="button" class="btn btn-default"
									data-value="publish">
									<?php _e( 'Publish', DLN_ABE ) ?>
								</button>
								<button type="button" class="btn btn-default"
									data-value="private">
									<?php _e( 'Private', DLN_ABE ) ?>
								</button>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-default">
									<i class="ico-smile"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel-footer">
		<button class="btn btn-primary pull-right" id="dln_submit_photo" type="button"><?php _e( 'Post', DLN_ABE ) ?></button>
	</div>
</div>