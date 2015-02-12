(function ($) {
    "use strict";

    var AdDetail = function () {
        var self = this;
        this.$cache  = window.ad_cache;
        this.$helper = window.ad_helper;
        
        // Check allow editable
        if ($('#dln_allow_editable').length && $('#dln_allow_editable').val() == 1) {
            this.initEditable();
            this.editTitle();
            this.editPrice();
            this.editLocation();
            this.editDesc();
            this.editBed();
            this.editBath();
        } else {
            $('.dln-property-price').each(function () {
                var val = $(this).text();
                val = self.$helper.formatCurrency(val) + ' ₫';
                $(this).text(val);
            });
        }
    };
    
    AdDetail.prototype.initEditable = function () {
        //console.log('AdDetail::initEditable::start');
        var self = this;
        
        if (typeof($.fn.editable) != 'function')
            return false;
        
        $.fn.editable.defaults.url          = window.root_api_url + '/ad_edit';
        $.fn.editable.defaults.placement    = 'bottom';
        $.fn.editable.defaults.mode         = 'inline';
        $.fn.editable.defaults.showbuttons  = false;
        $.fn.editable.defaults.onblur       = 'submit';
        
        $('.editable').each(function () {
            var self = this;
            
            // Set default text
            var relate     = $(self).data('relate');
            var suffix     = $(self).data('suffix');
            
            var relate_val = $('#dln_ad_' + relate).val();
            
            if (typeof(suffix) != 'undefined') {
                $(self).text(relate_val + ' ' + suffix);
            } else if (typeof(relate_val) != 'undefined') {
                $(self).text(relate_val);
            }
            
            $(this).on('save', function(e, params) {
                var relate = $(this).data('relate');
                $('#dln_ad_' + relate).val(params.newValue);
            });
            
            $(this).on('shown', function(e, editable) {
                var relate = $(this).data('relate');
                var relate_val = $('#dln_ad_' + relate).val();
                if (relate == 'price' && typeof(relate_val) != 'undefined') {
                    relate_val = relate_val.replace(',', '');
                    relate_val = relate_val.replace('₫', '');
                    relate_val = relate_val.replace(' ', '');
                }
                editable.input.$input.val(relate_val);
            });
        });
        
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
    };
    
    /* Init editable title */
    AdDetail.prototype.editTitle = function () {
        var self = this;
        
        $('.dln-property-title.editable').editable({
            validate: function(value) {
                if($.trim(value) == '') return 'Trường này không thể rỗng!';
            }
        });
    };
    
    /* Init editable price */
    AdDetail.prototype.editPrice = function () {
        var self = this;
        
        $('.dln-property-price.editable').editable({
            display: function (value) {
                $(this).text(self.$helper.formatCurrency(value) + ' ₫');
            },
            validate: function(value) {
                if($.trim(value) == '') return 'Trường này không thể rỗng!';
            }
        });
    };
    
    /* Init editable location */
    AdDetail.prototype.editLocation = function () {
    	var self = this;
    	
    	$('.dln-property-location.editable').editable({
    	});
    };
    
    /* Init editable description */
    AdDetail.prototype.editDesc = function () {
    	var self = this;
    	
    	$('.dln-property-desc.editable').editable({
            validate: function(value) {
                if($.trim(value) == '') return 'Trường này không thể rỗng!';
            }
    	});
    };
   
    AdDetail.prototype.editBed = function () {
        var self = this;
        
        if (self.$cache.data.bed) {
            var options = [];
            
            $.each(JSON.parse(self.$cache.data.bed), function (key, value) {
                var option = {};
                option.value = key;
                option.text  = value;
                options.push(option);
            });
            
            $('.dln-bed-room.editable').editable({
                type: 'select',
                mode: 'popup',
                source: options
            });
        }
    };
    
    AdDetail.prototype.editBath = function () {
        var self = this;
        
        if (self.$cache.data.bath) {
            var options = [];
            
            $.each(JSON.parse(self.$cache.data.bed), function (key, value) {
                var option = {};
                option.value = key;
                option.text  = value;
                options.push(option);
            });
            
            $('.dln-bath-room.editable').editable({
                type: 'select',
                mode: 'popup',
                source: options
            });
        }
    };
   
    $(document).ready(function () {
       var ad_detail = new AdDetail();
    });

}(window.jQuery));
