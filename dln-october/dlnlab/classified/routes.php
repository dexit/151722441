<?php

App::before(function ($request) {
    $api_path  = '/api/v1/';
    $api_class = 'DLNLab\Classified\Classes';
    
    Route::get($api_path . 's/{query}',            $api_class . '\RestAd@getSearch');
    Route::get($api_path . 'ad/{id}/nearby',            $api_class . '\RestAd@getNearby');
    Route::put($api_path . 'ad/{id}',              $api_class . '\RestAd@putAd');
    Route::put($api_path . 'ad/{id}/favorite',  $api_class . '\RestAd@putAdFavorite');
    Route::put($api_path . 'ad/active',   $api_class . '\RestAd@putActiveAd');
	Route::post($api_path . 'ad/{id}/upload',  $api_class . '\RestAd@postUpload');
    Route::post($api_path . 'ad/share',   $api_class . '\RestAd@postShareAd');
    
	Route::get($api_path . 'crawl/ad_deactive',    $api_class . '\RestCrawl@getAdDeactive');
	Route::get($api_path . 'crawl/tag_count',      $api_class . '\RestCrawl@getRefreshTagCount');
    Route::get($api_path . 'crawl/ad_share',       $api_class . '\RestCrawl@getAdShareCrawl');
    Route::get($api_path . 'crawl/ad_share_count', $api_class . '\RestCrawl@getAdShareCount');
    //Route::post($api_path . 'crawl/ad_share_page_status',    $api_class . '\RestCrawl@postAdShareStatusCrawl');
    
    Route::get($api_path . 'login_fb',    $api_class . '\RestAccessToken@getAuthenticateFB');
    Route::get($api_path . 'callback_fb', $api_class . '\RestAccessToken@getCallbackFB');
    Route::get($api_path . 'login_gp',    $api_class . '\RestAccessToken@getAuthenticateGPlus');
    Route::get($api_path . 'callback_gp', $api_class . '\RestAccessToken@getCallbackGP');
    Route::post($api_path . 'post_fb',    $api_class . '\RestAccessToken@postFeedFB');
    
    Route::get($api_path . 'update_page_access_token', $api_class . '\RestAccessToken@getUpdatePageAccessTokenFB' );
    Route::post($api_path . 'login',                   $api_class . '\RestAccount@postLogin');
    Route::get($api_path . 'logout',                   $api_class . '\RestAccount@getLogout');
});

Route::group(array('before' => 'csrf'), function() {
    $api_path  = '/api/v1/';
    $api_class = 'DLNLab\Classified\Classes';
    
    Route::post($api_path . 'ad/quick',  $api_class . '\RestAd@postAdQuick');
});
//http://cube.adbee.technology/gallery.html