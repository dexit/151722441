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

    .dln_upload_button {
        border: 1px solid #CCCCCC;
        border-radius: 5px 5px 5px 5px;
        color: #333333;
        font-weight: bold;
        margin: 5px 0 15px;
        padding: 3px 8px;
        text-decoration: none;
    }
    
    .dln-upload-container {
    	background-color: #f9fafc;
	    border: 2px dashed #eaedf1;
	    padding: 1em;
	    position: relative;
	    text-align: center;
    }
    
    .dln-uploaded-files {
    	width: 19%;
    	float: left;
    	padding-left: 10px;
    	padding-right: 10px;
    	margin: 5px;
    }
    
    .dln-progress-text{
    	margin-top: 10px;
    }

</style>
<div id="dln-upload-container" class="dln-upload-container">
    <a id="dln-uploader" class="btn btn-primary btn-lg dln_upload_button" href="#"><i class="ico-cloud-upload"></i> Upload</a>

    <div id="dln-upload-imagelist">
    	<div class="dln-progress-text progress progress-xs progress-striped active" style="display:none">
    		<div class="progress-bar progress-bar-success" style="width: 0%"><span class="sr-only"></span></div>
    	</div>
        <div id="dln-ul-list" class="dln-upload-list"></div>
    </div>

</div>