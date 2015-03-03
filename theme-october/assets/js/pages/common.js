(function ($) {
    "use strict";

    var AdCommon = function () {
        var token = $('input[name="_token"]').val();
        if (token) {
            $.ajaxSetup({
            	headers: {
                    'X-CSRF-Token': token
                }
            })
        }
        
        
        // Initialize select2
        $.fn.select2 && $('[data-init-plugin="select2"]').each(function () {
            $(this).select2({
                minimumResultsForSearch: "true" == $(this).attr("data-disable-search") ? -1 : 1
            }).on("select2-opening", function () {
                $.fn.scrollbar && $(".select2-results").scrollbar({
                    ignoreMobile: !1
                })
            })
        });

        /* Initialize tooltip */
        $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip();
    };
    
    AdCommon.prototype.showError = function (responseText) {
        var response = JSON.parse(responseText);
        $('body').pgNotification({
            message: response.message,
            type: 'danger'
        }).show();
    };
    
    $(document).ready(function () {
        window.ad_common = new AdCommon();

        // Masked inputs initialization
        $.fn.inputmask && $('[data-toggle="masked"]').inputmask();
    });

}(window.jQuery));