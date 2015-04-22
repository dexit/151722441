<?php

App::before(function ($request) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: X-Requested-With, content-type");
    
    $api_path = '/api/v1/';
    $api_class = 'DLNLab\SNSContacts\Classes';
    
    Route::get($api_path . 'token', $api_class . '\RestUser@getToken');
    
    
});
