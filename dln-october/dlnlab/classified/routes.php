<?php

App::before(function ($request) {
    Route::put('/api/v1/ad/active',        'DLNLab\Classified\Classes\RestAd@putActiveAd');
	Route::post('/api/v1/ad/upload',       'DLNLab\Classified\Classes\RestAd@postUpload');
	Route::post('/api/v1/crawl/ad_active', 'DLNLab\Classified\Classes\RestCrawl@postAdActive');
	Route::post('/api/v1/crawl/tag_count', 'DLNLab\Classified\Classes\RestCrawl@postRefreshTagCount');
});
