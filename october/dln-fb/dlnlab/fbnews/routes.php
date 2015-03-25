<?php

App::before(function ($request) {
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');
    
    $api_path = '/api/v1/';
    $api_class = 'DLNLab\FBNews\Classes';

    Route::delete($api_path . 'crawl/pages', $api_class . '\RestCrawl@deleteFeedSpec');
    Route::get($api_path . 'crawl/page_infor', $api_class . '\RestCrawl@getUpdateFBPageInfor');
    Route::get($api_path . 'crawl/page_feeds', $api_class . '\RestCrawl@getFBPageLinks');
    Route::get($api_path . 'crawl/feed_expired', $api_class . '\RestCrawl@getFeedExpired');
    Route::get($api_path . 'crawl/pages/{page_id}', $api_class . '\RestCrawl@getPageSpec');
    Route::get($api_path . 'category', $api_class . '\RestCategory@getCategoryList');
    Route::get($api_path . 'category/{category_id}', $api_class . '\RestCategory@getCategoryList');
    Route::get($api_path . 'feeds', $api_class . '\RestFeed@getFeeds');
    Route::get($api_path . 'page', $api_class . '\RestPage@getPageList');
    Route::get($api_path . 'page/{page_id}', $api_class . '\RestPage@getPageDetail');
    Route::get($api_path . 'page/{page_id}/feeds', $api_class . '\RestFeed@getFeedsByPage');
    Route::get($api_path . 'redirect', $api_class . '\RestFeed@getRedirectUrl');
});
