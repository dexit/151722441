(function ($) {
    "use strict";

    var AdHelper = function () {
        this.initModal();
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
    
    AdHelper.prototype.initModal = function () {
        var self = this;
        
        // On close modal
        $('#dln_modal').on('hide.bs.modal', function (e) {
            $('#dln_modal .dln-body').html('');
        });
        
        $('.dln-modal').on('click', function (e) {
            e.preventDefault();
            
            var type    = $(this).data('type');
            if (! type) {
                return false;
            }
            var url     = window.root_url + '/modal?type=' + $(this).data('type');
            var options = $(this).data('options');
            var header  = $(this).data('header');
            var relate  = $(this).data('relate');
            if (relate) {
                url += '&values=' + $('#' + relate).val();
            }
            
            self.showModal();
            self.showModalLoading();
            $('#dln_modal .modal-header h5').text('');
            
            // Send ajax request for get html content
            $.ajax({
                type : 'POST',
                url : url,
                data : options,
                success: function (response) {
                    self.hideModalLoading();
                    $('#dln_modal .modal-header h5').text(header);
                    $('#dln_modal .dln-body').html(response);
                },
            });
        });
    };
    
    AdHelper.prototype.showModal = function () {
        // Show modal with loading indicator
        $('#dln_modal').modal('show');
    };
    
    AdHelper.prototype.hideModal = function () {
        // Show modal with loading indicator
        $('#dln_modal').modal('hide');
    };
    
    AdHelper.prototype.hideModalLoading = function () {
        $('#dln_modal .dln-loading').removeClass('show');
    };
    
    AdHelper.prototype.showModalLoading = function () {
        $('#dln_modal .dln-loading').addClass('show');
    };
   
    $(document).ready(function () {
       window.ad_helper = new AdHelper();
    });

}(window.jQuery));
