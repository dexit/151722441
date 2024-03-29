<script type="text/javascript">window.dln_upload_count = 0;</script>
<style type="text/css">
.site {
	max-width: 950px
}

.dln-upload-list {
	display: table;
	width: 100%;
}

.action-delete {
	background: none repeat scroll 0 0 #F2F2F2;
	border: 1px solid #CCCCCC;
	border-radius: 5px 5px 5px 5px;
	color: #333333;
	font-size: 12px;
	font-weight: bold;
	padding: 3px 8px;
	text-decoration: none;
	position: absolute;
	right: 0px;
	top: 0px;
	padding: 4px !important;
	width: 20px;
	height: 20px;
	font-size: 10px !important;
	line-height: 10px !important;
	color: #FFFFFF;
	z-index: 10;
}

.dln-upload-container {
	background-color: #f9fafc;
	border: 2px dashed #eaedf1;
	padding: 1em;
	position: relative;
	text-align: center;
}

.dln-uploaded-files {
	float: left;
	min-width: 200px;
	padding-left: 10px;
	padding-right: 10px;
	margin: 5px;
}

.dln-progress-text {
	margin-top: 10px;
}

.dln-upload-container .thumbnail .media .meta {
	padding: 5px !important;
}
</style>
<div id="dln-upload-container" class="dln-upload-container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-dismissable alert-warning dln-text-left">
				<button type="button" class="close" data-dismiss="alert"
					aria-hidden="true">×</button>
				<strong>Warning!</strong> Best check yo self, you're not looking too
				good.
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
				<a id="dln_uploader" class="btn btn-primary dln-btn" href="#"><i
					class="ico-cloud-upload"></i> <?php _e( 'Upload from PC', DLN_CLF ) ?></a>
			</div>
			<div class="col-md-6">
				<a id="dln_fetch_url" class="btn btn-success dln-btn" href="#"><i
					class="ico-globe"></i> <?php _e( 'Fetch from URL', DLN_CLF ) ?></a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div id="dln-upload-imagelist">
				<div
					class="dln-progress-text progress progress-xs progress-striped active"
					style="display: none">
					<div class="progress-bar progress-bar-success" style="width: 0%">
						<span class="sr-only"></span>
					</div>
				</div>
				<div id="dln-ul-list" class="dln-upload-list"></div>
			</div>
		</div>
	</div>
</div>
<!-- START modal -->
<div id="dln_modal_fetch_url" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h3 class="semibold modal-title text-danger"><?php _e( 'Fetch images from URL', DLN_CLF ) ?></h3>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label"><?php _e( 'URL', DLN_CLF ) ?> <span class="text-danger">*</span></label>
							<input type="text" value="http://" id="dln_url_fetch" required="" placeholder="<?php _e( 'http://', DLN_CLF ) ?>" class="form-control">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e( 'Close', DLN_CLF )?></button>
				<button type="button" id="dln_submit_url_fetch" class="btn btn-primary"><?php _e( 'Fetch', DLN_CLF ) ?></button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!--/ END modal -->