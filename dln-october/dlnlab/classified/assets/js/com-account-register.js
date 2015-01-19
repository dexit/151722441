(function ($) {
    "use strict";

    var AccountRegister = function () {
        this.initModalRegister();
    };

    AccountRegister.prototype.initModalRegister = function () {
        var self = this;

    	$('#dln_modal_register').modal('show');
    };

    $(document).ready(function () {
        var accountRegister = new AccountRegister();
    });

}(jQuery));

