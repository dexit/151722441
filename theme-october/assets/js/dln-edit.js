(function ($) {
	"use strict";
	
	$(document).ready(function () {
		$('#dln_wizard').bootstrapWizard({
            onTabShow: function(tab, navigation, index) {
            },
            onNext: function(tab, navigation, index) {
                console.log("Showing next tab");
            },
            onPrevious: function(tab, navigation, index) {
                console.log("Showing previous tab");
            },
            onInit: function() {
                $('#dln_wizard ul').removeClass('nav-pills');
            }
        });
	});
}(jQuery));