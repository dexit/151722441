<?php

App::before(function ($request) {
	Route::post('/api/v1/ad/upload',       'DLNLab\Classified\Classes\RestAd@postUpload');
	Route::post('/api/v1/crawl/ad_active', 'DLNLab\Classified\Classes\RestCrawl@postAdActive');
});
