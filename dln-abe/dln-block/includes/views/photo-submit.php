<?php

if ( ! defined( 'WPINC' ) ) { die; }

// Array of defined attribute taxonomies
$attribute_taxonomies = wc_get_attribute_taxonomies();

?>

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
				<button class="btn btn-primary ladda-button ladda-progress mb5 dln-select" data-style="expand-right">
					<span class="ladda-label"><?php _e( 'Select photo', DLN_ABE ) ?> </span>
				</button>
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
							<?php echo balanceTags( DLN_Helper_Photo_Tmpl::render_product_images( '1' ) ) ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-4">
							<?php echo balanceTags( DLN_Helper_Photo_Tmpl::render_product_images( '2' ) ) ?>
						</div>
						<div class="col-sm-4">
							<?php echo balanceTags( DLN_Helper_Photo_Tmpl::render_product_images( '3' ) ) ?>
						</div>
						<div class="col-sm-4">
							<?php echo balanceTags( DLN_Helper_Photo_Tmpl::render_product_images( '4' ) ) ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<legend><?php _e( 'Item Settings', DLN_ABE ) ?></legend>
				
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<?php echo balanceTags( DLN_Block_Photo_Submit::get_field( 'basic', 'product_title' ) ) ?>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<?php echo balanceTags( DLN_Block_Photo_Submit::get_field( 'basic', 'product_category' ) ) ?>
						</div>
						<div class="col-sm-6">
							<?php echo balanceTags( DLN_Block_Photo_Submit::get_field( 'basic', 'product_price' ) ) ?>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<?php echo balanceTags( DLN_Block_Photo_Submit::get_field( 'basic', 'product_desc' ) ) ?>
						</div>
					</div>
				</div>
				
				<?php 
				foreach ( $attribute_taxonomies as $tax ) {

					// Get name of taxonomy we're now outputting (pa_xxx)
					$attribute_taxonomy_name = wc_attribute_taxonomy_name( $tax->attribute_name );

					// Ensure it exists
					if ( ! taxonomy_exists( $attribute_taxonomy_name ) )
						continue;
					
					echo '<div data-relate-id="' . esc_attr( $attribute_taxonomy_name ) . '" class="form-group row dln-hidden-data">';
					
					$label = $tax->attribute_label ? $tax->attribute_label : $tax->attribute_name;
					echo '<label class="col-sm-4 control-label">' . $label . '</label>';
					
					if ( $tax->attribute_type == "select" ) {
				
						$all_terms = get_terms( $attribute_taxonomy_name, 'orderby=name&hide_empty=0' );
						if ( $all_terms ) {
							echo '<div class="col-sm-6">';

							echo '<select multiple class="form-control dln-meta-value dln-selectize-multi">'; 
							foreach ( $all_terms as $term ) {
								$has_term =  0;
								echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( $has_term, 1, false ) . '>' . $term->name . '</option>';
							}
							echo '</select>';

							echo '</div>';
						}
						
					} elseif ( $tax->attribute_type == "text" ) {
						echo '<div class="col-sm-6">';
						echo '<input class="form-control dln-meta-value" type="text" value="" placeholder="' . __( 'Pipe (|) separate terms', DLN_ABE ) . '" />';
						echo '</div>';
					}
					
					echo '<div class="col-sm-2"><a class="dln-field-close btn btn-default"><i class="ico-close2"></i></a></div>';
					
					echo '</div>';
				}
				?>
				
				<div class="form-group">
					<div class="row">
						<div class="col-xs-4">
							<select id="dln_product_attribute" class="form-control dln-selectize">
								<?php 
								if ( $attribute_taxonomies ) {
									foreach ( $attribute_taxonomies as $tax ) {
										$attribute_taxonomy_name = wc_attribute_taxonomy_name( $tax->attribute_name );
										$label = $tax->attribute_label ? $tax->attribute_label : $tax->attribute_name;
										echo '<option value="' . esc_attr( $attribute_taxonomy_name ) . '">' . esc_html( $label ) . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-xs-8">
							<a class="btn btn-default dln-add-attr" href="#"><?php _e( 'Add Attribute', DLN_ABE ) ?></a>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<?php echo balanceTags( DLN_Block_Photo_Submit::get_field( 'basic', 'product_tag' ) ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel-footer">
		<button class="btn btn-primary pull-right" id="dln_submit_product" type="button"><?php _e( 'Post', DLN_ABE ) ?></button>
	</div>
</div>