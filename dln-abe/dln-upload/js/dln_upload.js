(function($) {
	"use strict";
	
	window.DLN_Block_Item = window.DLN_Block_Item || {};
	
	window.DLN_Block_Item.count = 0;
	
	window.DLN_Block_Item.imageTemplate = function ( data ) {
		if ( ! data )
			return '';
		
		var tmpl = '';
		tmpl += '<div class="item thumbnail dln-uploaded-files col-md-2">';
		tmpl += '	<div class="media">';
		tmpl += '	<div class="overlay"> <div class="toolbar"> <a class="btn btn-default dln-select-photo" href="#"><i class="ico-close2"></i></a> </div> </div>';
		tmpl += '	<img alt="' + data.title +  '" width="100%" src="' + data.src + '" style="display: inline;">';
		tmpl += '	<a href="#" class="btn btn-primary btn-sm action-delete" data-upload_id="' + data.attach_id + '"><i class="ico-close2"></i></a></span>';
		tmpl += '	<input type="hidden" class="dln-image-id" name="dln_image_id[]" value="' + data.attach_id + '" />';
		tmpl += '	</div>';
		tmpl += '</div>';
		
		return tmpl;
	};
	
	window.DLN_Block_Item.appendToImageWrapper = function ( action, data ) {
		var html = '';
		switch ( action ) {
			case 'from-pc':
				data = JSON.parse( data );
				//html = window.DLN_Block_Item.imageTemplate( data );
				$('body').trigger('dln_complete_upload', [data]);
				break;
			case 'from-fetch':
				data = JSON.parse( data );
				html = '';
				for( var i = 0; i < data.length; i++ ) {
					var obj       = {};
					obj.src       = data[i];
					obj.attach_id = '0';
					obj.title     = '';
					html += window.DLN_Block_Item.imageTemplate( obj );
				}
				break;
		}
		$('#dln-upload-imagelist .dln-upload-list').append( html );
	};
	
	var DLN_Upload = {
	        init : function () {
	            window.dln_upload_count = typeof( window.dln_upload_count ) == 'undefined' ? 0 : window.dln_upload_count;
	            this.max_files          = parseInt( dln_upload.number );

	            $('#dln-upload-imagelist').on('click', 'a.action-delete', this.removeUploads);

	            this.attach();
	            this.hideUploader();
	        },
	        
	        attach : function () {
	            // wordpress plupload if not found
	            if ( typeof( plupload ) === 'undefined' ) {
	                return;
	            }
	            
	            if ( dln_upload.upload_enabled !== '1' ) {
	                return;
	            }
	            
	            var uploader = new plupload.Uploader( dln_upload.plupload );
	            
	            $( '#dln_uploader' ).click( function (e) {
	            	// To prevent default behavior of a tag
	                e.preventDefault();
	                
	            	$(".dln-progress-text .progress-bar").css( {'width': "0%"} );
	                uploader.start();
	            } );

	            //initilize  wp plupload
	            uploader.init();

	            uploader.bind( 'FilesAdded', function ( up, files ) {
	                $.each(files, function (i, file) {
	                    $('#dln-upload-imagelist').append(
	                        '<div id="' + file.id + '">' +
	                            file.name + ' (' + plupload.formatSize(file.size) + ')' +
	                            '</div>');
	                } );

	                up.refresh(); // Reposition Flash/Silverlight
	                uploader.start();
	            } );

	            uploader.bind( 'UploadProgress', function ( up, file ) {
	            	$(".dln-progress-text").show();
	                $(".dln-progress-text .progress-bar").css( {'width': file.percent  + "%"} );
	            } );

	            // On erro occur
	            uploader.bind('Error', function (up, err) {
	                $('#dln-upload-imagelist').append( '<div>Error: ' + err.code +
	                    ', Message: ' + err.message +
	                    ( err.file ? ', File: ' + err.file.name : '' ) +
	                    '</div>'
	                );

	                up.refresh(); // Reposition Flash/Silverlight
	            });

	            uploader.bind( 'FileUploaded', function ( up, file, response ) {
	                var result = $.parseJSON( response.response );
	                $('#' + file.id).remove();
	                if ( result.success ) {
	                    window.dln_upload_count += 1;
	                    $(".dln-progress-text").hide();
	                    
	                    window.DLN_Block_Item.appendToImageWrapper( 'from-pc', result.html );

	                    DLN_Upload.hideUploader();
	                }
	            } );
	        },

	        hideUploader:function () {
	            if ( DLN_Upload.max_files !== 0 && window.dln_upload_count >= DLN_Upload.max_files ) {
	                $( '#dln_uploader' ).hide();
	            }
	        },

	        removeUploads:function (e) {
	            e.preventDefault();

	            if ( confirm( dln_upload.confirm_msg ) ) {

	                var el = $( this ),
	                    data = {
	                        'attach_id': el.data( 'upload_id' ),
	                        'nonce'    : dln_upload.remove,
	                        'action'   : 'dln_delete'
	                    };

	                $.post( dln_upload.ajaxurl, data, function () {
	                    el.closest('.dln-uploaded-files').remove();

	                    window.dln_upload_count -= 1;
	                    if ( DLN_Upload.maxFiles !== 0 && window.dln_upload_count < DLN_Upload.max_files ) {
	                        $('#dln_uploader').show();
	                    }
	                } );
	            }
	        }

	    };
	
	$(document).ready(function () {
		
		DLN_Upload.init();
		
	});
}(jQuery));