(function ($) {
    "use strict";

    var AccountRegister = function () {
        this.initValidator();
        this.initFacebook();
        this.initGooglePlus();
        
        // On click email button
        $('#dln_register_email').on('click', function (e) {
        	$(this).hide();
        	
    		$('#dln_modal_register .social-buttons').hide();
    		$('#dln_modal_register .social-links').show();
    		$('.register-block').show();
    		$('.login-block').hide();
    	});
        $('#toggle_login').on('click', function (e) {
        	$(this).hide();
        	
        	$('.register-block').hide();
    		$('.login-block').show();
    		$('#dln_modal_register .social-buttons').hide();
    		$('#dln_modal_register .social-links').show();
    		
    		$('#toggle_register').show();
        });
        $('#toggle_register').on('click', function (e) {
        	$(this).hide();

    		$('#dln_form_login').hide();
        	$('.register-block').show();
    		$('.login-block').hide();
			$('#dln_form_register').hide();
			$('#dln_modal_register .social-buttons').show();
    		$('#dln_modal_register .social-links').hide();
    		$('#dln_register_email').show();
        	
        	$('#toggle_login').show();
        });
        
        
        // On register account by email
    	$('#dln_btn_register').on('click', function (e) {
    		e.preventDefault();
    		if ($('#dln_form_register').valid()) {
    			$('#dln_form_register').request('onRegister', {
    				success: function (response) {
    					console.log(response);
    					//$('#dln_modal_register').modal('hide');
    					//location.reload();
    				},
    				error: function (_jqXHR, textStatus, errorThrown) {
    					var obj = JSON.parse(_jqXHR.responseText);
    					if (obj.X_OCTOBER_ERROR_MESSAGE) {
    						alert(obj.X_OCTOBER_ERROR_MESSAGE);
    					} else {
    						alert(_jqXHR.responseText);
    					}
    				}
    			});
    		}
    	});
    	
    	// On Login
    	$('#dln_btn_login').on('click', function (e) {
    		e.preventDefault();
    		var self = this;
    		if ($('#dln_form_login').valid()) {
    			$.ajax({
    				type: 'POST',
    				url: window.root_url_api + '/login',
    				data: $('#dln_form_login').serialize(),
    				success: function (data) {
    					console.log(data);
    				},
    				error: function (data) {
    					if (data.responseText) {
    						alert(data.responseText);
    					} else {
    						console.log(data);
    					}
    				}
    			});
    		}
    	});
    };
    
    AccountRegister.prototype.initValidator = function () {
    	// Add jquery validation
        var validator = $('#dln_form_register').validate();
    };
    
    AccountRegister.prototype.initFacebook = function () {
    	///api/v1/login_fb
    	$('.dln-register-facebook').on('click', function (e) {
    		window.location.href = window.root_url_api + '/login_fb?return_url=' + window.location.href;
    	});
    };
    
    AccountRegister.prototype.initGooglePlus = function () {
    	$('.dln-register-googleplus').on('click', function (e) {
    		window.location.href = window.root_url_api + '/login_gp?return_url=' + window.location.href;
    	});
    };
    
    $(document).ready(function () {
        var accountRegister = new AccountRegister();
    });

}(jQuery));

