(function ($) {
    "use strict";

    var AdDetail = function () {
    	this.initWizard();
    	this.initInputMask();
    	this.initSelect2Plugin();
    	this.initPhotoUpload();
        this.addLatLngDragMap();
    };

    AdDetail.prototype.addLatLngDragMap = function () {
        var self = this;
    };
    
    /**
     * Initialize form wizard library
     */
    AdDetail.prototype.initWizard = function () {
    	$('#dln_wizard').bootstrapWizard({
            onTabShow: function(tab, navigation, index) {
            },
            onNext: function(tab, navigation, index) {
                console.log("Showing next tab");
            },
            onPrevious: function(tab, navigation, index) {
                console.log("Showing previous tab");
            },
            onInit: function() {
                $('#dln_wizard ul').removeClass('nav-pills');
            }
        });
    };
    
    /**
     * Initialize input mask library
     */
    AdDetail.prototype.initInputMask = function () {
    	// Masked inputs initialization
	    $.fn.inputmask && $('[data-toggle="masked"]').inputmask();
    };
    
    /**
     * Initialize select2
     */
    AdDetail.prototype.initSelect2Plugin = function() {
        $.fn.select2 && $('[data-init-plugin="select2"]').each(function() {
            $(this).select2({
                minimumResultsForSearch: "true" == $(this).attr("data-disable-search") ? -1 : 1
            }).on("select2-opening", function() {
                $.fn.scrollbar && $(".select2-results").scrollbar({
                    ignoreMobile: !1
                })
            })
        })
    };
    
    /**
     * Initialize upload photos
     */
    AdDetail.prototype.initPhotoUpload = function () {
    	var self = this;
    	
    	$('.dln-file-wrapper button').on('click', function (e) {
    		e.preventDefault();
    		$('.dln-file-upload').trigger('click');
    	});
    	
    	/*$('.dln-file-upload').dropzone({
			url: 'api/v1/ad/upload',
			paramName: 'file_data'
		});*/
    	$('.dln-file-upload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: 'api/v1/ad/upload',
            paramName: 'file_data',
            done: function(e, data){
            	if (data.result.code == 200) {
            		self.createPhotoAd(data.result);
            	}
            }
        })
    };
    
    /**
     * Function create thumb ad image after upload
     */
    AdDetail.prototype.createPhotoAd = function (response) {
    	if (! response) return false;
    	var self = this;
    	
    	var html = response.data.photo_pattern;
    	html = html.replace('__SRC__', response.data.thumb);
    	$('.dln-photos-wrapper').append(html);
    };

    $(document).ready(function () {
        var adDetail = new AdDetail();
    });

}(window.jQuery));
