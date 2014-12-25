(function ($) {
	$(document).ready(function () {
		$('.dln-photo-placeholder').dropzone({
			url: 'api/v1/ad/upload',
			paramName: 'file_data'
		});
	});
}(jQuery));