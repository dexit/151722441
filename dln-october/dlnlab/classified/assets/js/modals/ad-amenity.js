(function ($) {
    "use strict";

    var ModalAmenity = function () {
        var self = this;
        
        $('.chk_amenities .checkbox label').on('click', function (e) {
            $(this).closest('.checkbox').find('input:checkbox').trigger('click');
        });
        
        $('.chk_amenities input:checkbox').on('click', function (e) {
            e.stopImmediatePropagation();
            
            var checked = '';
            var arr_checked = [];
            $('.chk_amenities input:checked').each(function () {
                var _value = $(this).val();
                checked += _value + ',';
                arr_checked.push(_value);
            });
            $('#dln_ad_amenities').val(array_checked);
            self.loadAmenity(arr_checked);
        });
    };
    
    ModalAmenity.prototype.loadAmenity = function (arr_checked) {
    	var html = '';
    	$.each(JSON.parse(this.$cache.$amenity), function (key, value) {
            if ($.inArray(value.id.toString(), arr_checked) !== -1) {
                html += '<span class="col-xs-6"><span class="dot dot-green"></span> ' + value.name + '</span>';
            }
    	});
    	$('.property-amenities .row').html(html);
    };
   
    $(document).ready(function () {
       var amenity = new ModalAmenity();
    });

}(window.jQuery));
