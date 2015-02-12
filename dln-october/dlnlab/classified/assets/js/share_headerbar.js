(function ($) {
    "use strict";

    var shareHeaderBar = function () {
    	$('.btn-logout-click').on('click', function (e) {
            e.preventDefault();

            window.location.href = window.root_url_api + '/logout?return_url=' + window.location.href;
    	});
    	$('.btn-login-click').on('click', function (e) {
            e.preventDefault();

            if ($('#dln_modal_register').length) {
                    $('#dln_modal_register').modal('show');
            }
    	});
        $('.btn-seach-click').on('click', function (e) {
            e.preventDefault();
            
            $('.dln-filter-xs').toggleClass('open');
        });
    };
   
    $(document).ready(function () {
       var headerbar = new shareHeaderBar();
    });

}(window.jQuery));
