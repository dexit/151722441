<?php

App::before(function ($request) {
	Route::post( '/api/v1/get_pincode',   'DLNLab\Features\Classes\RestPincode@postGetPincode' );
	Route::post( '/api/v1/valid_pincode', 'DLNLab\Features\Classes\RestPincode@postValidPincode' );
	
	Route::post( '/api/v1/sessions', 'DLNLab\Features\Classes\RestSession@postSession' );
	Route::delete( '/api/v1/sessions', 'DLNLab\Features\Classes\RestSession@deleteSession' );
});
