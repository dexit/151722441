<?php
?>

<div class="panel panel-default overflow-hidden">

	<div class="panel-heading">
		<h5 class="panel-title">Basic example</h5>
	</div>

	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<legend><?php _e( 'Item Settings', DLN_CLF ) ?></legend>
				
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<?php balanceTags( do_shortcode( '[dln_upload theme="true"]' ) ) ?>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<?php echo balanceTags( DLN_Block_Product_Item::get_field( 'basic', 'product_title' ) ) ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<?php echo balanceTags( DLN_Block_Product_Item::get_field( 'basic', 'product_category' ) ) ?>
						</div>
						<div class="col-sm-6">
							<?php echo balanceTags( DLN_Block_Product_Item::get_field( 'basic', 'product_price' ) ) ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<?php echo balanceTags( DLN_Block_Product_Item::get_field( 'basic', 'product_desc' ) ) ?>
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
								<select class="form-control dln-field-meta-key dln-selectize-create" placeholder="<?php _e( 'Select Attribute' ) ?>">
								</select>
							</div>
							<div class="col-xs-6">
								<input type="text" value="" class="form-control dln-field-meta-value" placeholder="<?php _e( 'Attribute Value' ) ?>" />
							</div>
							<div class="col-xs-2">
								<a class="dln-field-close btn btn-default">X</a>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>

	<div class="panel-footer">
		<div class="checkbox custom-checkbox pull-left">
			<input type="checkbox" name="gift" id="giftcheckbox" value="1"
				data-parsley-mincheck="1" required> <label for="giftcheckbox">&nbsp;&nbsp;Send
				as a gift</label>
		</div>
		<button class="btn btn-primary pull-right" id="dln_submit_product" type="button"><?php _e( 'Create Product', DLN_CLF ) ?></button>
	</div>
</div>