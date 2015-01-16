<?php

App::before(function ($request) {
    Route::put('/api/v1/ad/active',          'DLNLab\Classified\Classes\RestAd@putActiveAd');
	Route::post('/api/v1/ad/upload',         'DLNLab\Classified\Classes\RestAd@postUpload');
    Route::post('/api/v1/ad/share',          'DLNLab\Classified\Classes\RestAd@postShareAd');
	Route::post('/api/v1/crawl/ad_deactive', 'DLNLab\Classified\Classes\RestCrawl@postAdDeactive');
	Route::post('/api/v1/crawl/tag_count',   'DLNLab\Classified\Classes\RestCrawl@postRefreshTagCount');
    Route::post('/api/v1/crawl/ad_share',    'DLNLab\Classified\Classes\RestCrawl@postAdShareCrawl');
    Route::get('/api/v1/s/{query}', 'DLNLab\Classified\Classes\RestAd@getSearch');
    
    Route::get('/api/v1/login_fb', 'DLNLab\Classified\Classes\RestAccessToken@getAuthenticateFB');
    Route::get('/api/v1/callback_fb', 'DLNLab\Classified\Classes\RestAccessToken@getCallbackFB');
    Route::post('/api/v1/post_fb', 'DLNLab\Classified\Classes\RestAccessToken@postFeedFB');
});
