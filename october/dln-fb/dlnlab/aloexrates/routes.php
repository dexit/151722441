<?php

App::before(function ($request) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: X-Requested-With, content-type");
    
    $api_path = '/api/v1';
    $api_class = 'DLNLab\AloExrates\Classes';
    
    Route::post($api_path . '/devices', $api_class . '\RestDevices@postRegisterDevice');
    Route::get($api_path . '/crawl/exrates', $api_class . '\RestCrawl@getExrates');
});
