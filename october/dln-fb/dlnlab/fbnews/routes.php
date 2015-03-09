<?php

App::before(function ($request) {
    $api_path  = '/api/v1/';
    $api_class = 'DLNLab\FBNews\Classes';
    
	Route::get($api_path . 'crawl/page_infor', $api_class . '\RestCrawl@getUpdateFBPageInfor');
    Route::get($api_path . 'crawl/page_links', $api_class . '\RestCrawl@getUpdateFBPageLinks');
});