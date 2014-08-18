(function($) {
	"use strict";
	
	$(document).ready(function () {
		$.DLN_Social_Helper.addLoginFBButton();
		$.DLN_Social_Helper.addLoginInstaButton();
		
		$("[data-toggle~=unveil]").unveil(200, function() {
            $(this).load(function() {
                $(this).addClass("unveiled");
            })
        })
	});
}(jQuery));