(function($) {
    "use strict";

    var ModalPhoto = function() {
        this.$ad_id = '';
        this.initPhotoUpload();
        this.initPhotoReorder();
    };

    /**
     * Initialize upload photos
     */
    ModalPhoto.prototype.initPhotoUpload = function() {
        var self = this;

        $('.dln-file-wrapper .btn').on('click', function(e) {
            e.preventDefault();

            self.$ad_id = $('dln_ad_id').val();
            $('.dln-file-upload').trigger('click');
        });

        $('.dln-file-upload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: window.root_url_api + 'ad/' + self.$ad_id + '/upload',
            paramName: 'file_data',
            send: function(e, data) {
                window.ad_helper.showModalLoading();
            },
            done: function(e, data) {
                window.ad_helper.hideModalLoading();
                if (data.result.code == 200) {
                    self.createPhotoAd(data.result);
                }
            }
        })
    };

    ModalPhoto.prototype.initSetFeaturePhoto = function() {
        $('.dln-feature-photo').on('click', function(e) {
            e.preventDefault();

            var id = $(this).data('id');

            if (!id) {
                return false;
            }

            window.ad_helper.showModalLoading();
            $.ajax({
                type: 'PUT',
                url: window.root_url_api + '/photo/',
                data: {
                    action: 'feature'
                },
                success: function(response) {
                    window.ad_helper.hideModalLoading();
                }
            });
        });
    };
    
    ModalPhoto.prototype.initPhotoReorder = function () {
        $( '.dln-photos-wrapper' ).sortable({
            placeholder: 'ui-state-highlight'
        });
        $( '.dln-photos-wrapper' ).disableSelection();
    };

    ModalPhoto.prototype.createPhotoAd = function(response) {
        if (!response)
            return false;
        var self = this;

        var html = response.data.photo_pattern;
        $('.dln-photos-wrapper').append(html);

        self.initSetFeaturePhoto();
    };

    $(document).ready(function() {
        var photo = new ModalPhoto();
    });

}(window.jQuery));
