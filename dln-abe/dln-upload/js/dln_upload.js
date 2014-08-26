jQuery(document).ready(function ($) {
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
            	$(".dln-progress-text .progress-bar").css( {'width': "0%"} );
                uploader.start();
                // To prevent default behavior of a tag
                e.preventDefault();
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
                    
                    $.DLN_Block_Item.appendToImageWrapper( 'from-pc', result.html );

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

    DLN_Upload.init();
});