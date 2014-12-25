<?php

App::before(function ($request) {
	Route::post( '/api/v1/get_pincode',   'DLNLab\Features\Classes\RestPincode@postGetPincode' );
	Route::post( '/api/v1/valid_pincode', 'DLNLab\Features\Classes\RestPincode@postValidPincode' );
	
	Route::post( '/api/v1/report', 'DLNLab\Features\Classes\RestReport@postSendReport' );
	
	Route::post( '/api/v1/notification', 'DLNLab\Features\Classes\RestNotification@postRead' );
	
	Route::post( '/api/v1/sessions', 'DLNLab\Features\Classes\RestSession@postSession' );
	Route::delete( '/api/v1/sessions', 'DLNLab\Features\Classes\RestSession@deleteSession' );
	
	Route::post( '/api/v1/ad/upload', 'DLNLab\Features\Classes\RestAd@postUpload' );
});
