<?php

App::before(function ($request) {
    Route::put('/api/v1/ad/active',          'DLNLab\Classified\Classes\RestAd@putActiveAd');
	Route::post('/api/v1/ad/upload',         'DLNLab\Classified\Classes\RestAd@postUpload');
    Route::post('/api/v1/ad/share',          'DLNLab\Classified\Classes\RestAd@postShareAd');
	Route::get('/api/v1/crawl/ad_deactive', 'DLNLab\Classified\Classes\RestCrawl@getAdDeactive');
	Route::get('/api/v1/crawl/tag_count',   'DLNLab\Classified\Classes\RestCrawl@getRefreshTagCount');
    Route::get('/api/v1/crawl/ad_share',    'DLNLab\Classified\Classes\RestCrawl@getAdShareCrawl');
    Route::get('/api/v1/crawl/ad_share_count', 'DLNLab\Classified\Classes\RestCrawl@getAdShareCount');
    //Route::post('/api/v1/crawl/ad_share_page_status',    'DLNLab\Classified\Classes\RestCrawl@postAdShareStatusCrawl');
    Route::get('/api/v1/s/{query}', 'DLNLab\Classified\Classes\RestAd@getSearch');
    
    Route::get('/api/v1/login_fb', 'DLNLab\Classified\Classes\RestAccessToken@getAuthenticateFB');
    Route::get('/api/v1/callback_fb', 'DLNLab\Classified\Classes\RestAccessToken@getCallbackFB');
    Route::get('/api/v1/update_page_access_token','DLNLab\Classified\Classes\RestAccessToken@getUpdatePageAccessTokenFB' );
    Route::post('/api/v1/post_fb', 'DLNLab\Classified\Classes\RestAccessToken@postFeedFB');
    
    Route::post('/api/v1/login', 'DLNLab\Classified\Classes\RestAccount@postLogin');
});
