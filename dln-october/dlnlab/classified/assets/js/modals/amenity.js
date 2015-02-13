(function ($) {
    "use strict";

    var ModalAmenity = function () {
        $('.chk_amenities .checkbox label').on('click', function (e) {
            $(this).closest('.checkbox').find('input:checkbox').trigger('click');
        });
        $('.chk_amenities input:checkbox').on('click', function (e) {
            e.stopImmediatePropagation();
            
            var array_checked = '';
            $('.chk_amenities input:checked').each(function () {
                array_checked += $(this).val() + ',';
            });
            $('#dln_ad_amenities').val(array_checked);
        })
    };
   
    $(document).ready(function () {
       var amenity = new ModalAmenity();
    });

}(window.jQuery));
