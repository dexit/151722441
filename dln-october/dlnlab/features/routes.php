<?php

App::before(function ($request) {
	Route::resource('/', 'DLNLab\Features\Classes\RestPincode@test');
});