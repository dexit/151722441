(function($) {
	"use strict";
	
	var addUnveilLib = function () {
		// Add unveil lib
		$("[data-toggle~=unveil]").unveil(0, function() {
            $(this).load(function() {
                $(this).addClass("unveiled");
            })
        })
	};
	
	$(document).ready(function () {
		addUnveilLib();
	});
}(jQuery));