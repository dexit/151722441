<?php

if ( ! defined( 'WPINC' ) ) { die; }

$photo_submit_tmpl = DLN_Helper_Photo::renderPhotoSubmit();
?>
<div class="row">
	<div class="col-md-6">
		<?php echo balanceTag( $photo_submit_tmpl )?>
	</div>
</div>

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

<script type="text/javascript">
(function ($) {
	$.DLN_TemplateSubmitPhoto = '<?php echo $photo_submit_tmpl?>';
})(jQuery);
</script>