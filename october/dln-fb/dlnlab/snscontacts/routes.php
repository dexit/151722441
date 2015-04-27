<?php

App::before(function ($request) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: X-Requested-With, content-type");
    
    $api_path = '/api/v1';
    $api_class = 'DLNLab\SNSContacts\Classes';
    
    Route::get($api_path . '/token', $api_class . '\RestUser@getToken');
    Route::get($api_path . '/user/{user_id}', $api_class . '\RestUser@getUser');
    Route::post($api_path . '/user', $api_class . '\RestUser@postUser');
    Route::post($api_path . '/contact', $api_class . '\RestContact@postContact');
});
