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
    Route::get($api_path . 'feed_by_ids', $api_class . '\RestFeed@getFeedByIds');
    Route::get($api_path . 'pages', $api_class . '\RestPage@getPageList');
    Route::get($api_path . 'pages/{page_id}', $api_class . '\RestPage@getPageDetail');
    Route::get($api_path . 'pages/{page_id}/feeds', $api_class . '\RestFeed@getFeedsByPage');
    Route::get($api_path . 'cache', $api_class . '\RestCache@getCacheBasic');
    Route::get($api_path . 'helper/search_vote', $api_class . '\RestPage@getSearchPage');
    Route::get($api_path . 'helper/post', $api_class . '\RestCrawl@getPostFBPage');
    Route::post($api_path . 'vote', $api_class . '\RestVote@postAddVote');
});
