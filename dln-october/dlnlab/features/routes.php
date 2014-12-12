<?php

App::before(function ($request) {
	Route::post('/api/v1/get_pincode', 'DLNLab\Features\Classes\RestPincode@getPincode');
});