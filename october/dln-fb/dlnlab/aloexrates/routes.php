<?php

App::before(function ($request) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: X-Requested-With, content-type");
    
    $api_path = '/api/v1';
    $api_class = 'DLNLab\AloExrates\Classes';
    
    Route::post($api_path . '/devices', $api_class . '\RestDevices@postRegisterDevice');
    Route::get($api_path . '/devices/{id}/notifications', $api_class . 'RestDevices@getNotificationsById');
    Route::get($api_path . '/crawl/exrates', $api_class . '\RestCrawl@getExrates');
    Route::get($api_path . '/crawl/banks', $api_class . '\RestCrawl@getBankDaily');
    Route::get($api_path . '/crawl/golds', $api_class . '\RestCrawl@getGoldDaily');
    Route::get($api_path . '/crawl/notify', $api_class . 'RestCrawl@getSendNotificationDevices');
    Route::post($api_path . '/notifications', $api_class . '\RestNotification@postRegisterNotification');
    Route::get($api_path . '/notifications', $api_class . '\RestNotification@getNotificationByDeviceId');
    Route::get($api_path . '/currencies', $api_class . '\RestCurrency@getListCurrencies');
    Route::get($api_path . '/currencies/detail', $api_class . '\RestCurrency@getListCurrenciesDetail');
    Route::get($api_path . '/currencies/{id}', $api_class . '\RestCurrency@getCurrenciesById');
    Route::get($api_path . '/post/fb-daily', $api_class . '\RestCrawl@getPostToFBDaily');

    Route::get($api_path . '/test', $api_class . '\RestNotification@testNtfs');
});
