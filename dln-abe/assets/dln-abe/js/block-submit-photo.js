(function($) {
	"use strict";
	
	var loadIframeURL = function ( selector, url ) {
		console.log(( ! selector || ! url ));
		if ( ! selector || ! url )
			return false;
		
		// Create iframe
		$(selector).attr('src', url);
	};
	
	$(document).ready(function () {
		// Add select image action
		$('#dln_select_image').on('click', function (e) {
			e.preventDefault();

			var url = dln_clf_params.dln_site_url + '?dln_form=modal_select_photo';
			loadIframeURL( '#dln_iframe_select_photo iframe', url );
			
			$('#dln_iframe_select_photo').modal('show');
		});
	});
}(jQuery));