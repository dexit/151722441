(function ($) {
    "use strict";

    var AdHelper = function () {
    };
    
    AdHelper.prototype.formatCurrency = function (currency) {
        var currency = currency.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        return currency;
    };
   
    $(document).ready(function () {
       window.ad_helper = new AdHelper();
    });

}(window.jQuery));
