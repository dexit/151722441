(function ($) {
    "use strict";

    var AdDetail = function () {
        this.$cache = window.ad_cache;
        
        // Check allow editable
        if ($('#dln_allow_editable').length && $('#dln_allow_editable').val() == 1) {
            this.initEditable();
        }
    };
    
    AdDetail.prototype.initEditable = function () {
        //console.log('AdDetail::initEditable::start');
        var self = this;
        
        if (typeof($.fn.editable) != 'function')
            return false;
        
        $.fn.editable.defaults.url = window.root_api_url + '/ad_edit';
        
        // Enable / disable
        $('#dln_enable').on('click', function (e) {
            e.preventDefault();
            
            $('.editable').editable('toggleDisabled');
        });
        
        // Init Category
        $('body').bind('dln-init-category', function () {
            $('.dln-category.editable').editable({
                source: self.$cache.getCategoryOptions()
            });
        });
        $('body').trigger('dln-init-category');
        
        // Init Amenity
        $('body').bind('dln-init-amenity', function () {
            $('.dln-amenity.editable').editable({
                source: self.$cache.getAmenityOptions()
            });
        });
        $('body').trigger('dln-init-amenity');
        
        // Init Kind
        $('body').bind('dln-init-kind', function () {
            $('.dln-kind.editable').editable({
                source: self.$cache.getKindOptions()
            });
        });
        $('body').trigger('dln-init-kind');
        
        // Init price
        $('.dln-property-price.ediable').editable({
        	validate: function(value) {
                if($.trim(value) == '') return 'Trường này không thể rỗng!';
             }
        });
    };
   
    $(document).ready(function () {
       var ad_detail = new AdDetail();
    });

}(window.jQuery));
