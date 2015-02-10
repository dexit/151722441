(function ($) {
    "use strict";

    var AdHelper = function () {
    };
    
    AdHelper.prototype.formatCurrency = function (currency) {
        var currency = currency.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        return currency;
    };
    
    AdHelper.prototype.miniAutocomplete = function(autocomplete_id) {
    	var autocomplete = new google.maps.places.Autocomplete(document.getElementById(autocomplete_id), {
            types: ['geocode']
        });
    	
    	// For autocomplete
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            if (place.geometry) {
            	$('#dln_lat').val(place.geometry.location.lat());
            	$('#dln_lng').val(place.geometry.location.lng());
            } else {
            	$('#dln_lat').val(place.geometry.location.lat());
            	$('#dln_lng').val(place.geometry.location.lng());
            }
        });
    };
   
    $(document).ready(function () {
       window.ad_helper = new AdHelper();
    });

}(window.jQuery));
