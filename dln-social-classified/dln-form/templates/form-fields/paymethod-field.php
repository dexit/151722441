<?php 
	wp_enqueue_script( 'dln-form-field-paymethod-js', DLN_CLF_PLUGIN_URL . '/assets/js/fields/paymethod.js', array( 'jquery' ), '1.0.0', true );
?>
<div class="list-group">
	<div id="dln_payment_sale" class="list-group-item" href="javascript:void(0);" for="dln_payment_price">
		<div class="dln-box-payment">
			<div class="dln-payment-icon">
				<i class="ico-refresh"></i>
			</div>
			<div>
				<label><?php _e( 'For sale', DLN_CLF ) ?></label>
				<div>
					<?php _e( 'Your price', DLN_CLF ) ?>
					<input class="btn-sm" type="text" value="" placeholder="50" id="dln_fs_payment_price" name="dln_fs_payment_price"> 
					<span class="text-block">,000 đ</span>
				</div>
			</div>
		</div>
	</div> 
	<div id="dln_payment_swap" class="list-group-item" href="javascript:void(0);">
		<div class="dln-box-payment">
			<div class="dln-payment-icon">
				<i class="ico-coin"></i>
			</div>
			<div>
				<label><?php _e( 'For swap', DLN_CLF ) ?></label>
				<p class="help-block"><?php _e( 'Swap your clothes with other stylish girls!', DLN_CLF ) ?></p>
			</div>
		</div>
	</div>
</div>

<div class="list-group">
	<div id="dln_payment_gift" class="list-group-item" href="javascript:void(0);">
		<div class="dln-box-payment">
			<div class="dln-payment-icon">
				<i class="ico-gift2"></i>
			</div>
			<div>
				<label><?php _e( 'Make someone happy - give your item as a gift!', DLN_CLF ) ?></label>
				<p class="help-block"><?php _e( 'Make someone happy - give your item as a gift!', DLN_CLF ) ?></p>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="dln_payment_type" name="dln_payment_type" value="" />