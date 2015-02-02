(function ($) {
    "use strict";
    
    $(document).ready(function () {
    	// Masked inputs initialization
	    $.fn.inputmask && $('[data-toggle="masked"]').inputmask();
	    
	    // Initialize select2
	    $.fn.select2 && $('[data-init-plugin="select2"]').each(function() {
            $(this).select2({
                minimumResultsForSearch: "true" == $(this).attr("data-disable-search") ? -1 : 1
            }).on("select2-opening", function() {
                $.fn.scrollbar && $(".select2-results").scrollbar({
                    ignoreMobile: !1
                })
            })
        })
    });

}(window.jQuery));