<?php

namespace DLNLab\FBNews\Classes;

use Auth;
use DB;
use Carbon;
use Input;
use Response;
use Illuminate\Routing\Controller as BaseController;
use DLNLab\FBNews\Models\FbFee;
use Symfony\Component\DomCrawler\Crawler;

class RestNews extends BaseController {
	
	public static $params = null;
    public static $limit_crawl_ad_active = 100;
    public static $limit_crawl_tag_count = 10;
    
    public function getNews() {
        $data = get();
        
        $default = array(
            'category_id' => 0,
            'page' => 0
        );
        extract(array_merge($default, $data));
        
        if (empty($category_id))
            return Response::json(array('status' => 'error'), 500);
        
        $limit = DLN_LIMIT;
        $skip  = $page * $limit;
        
        $records = FbFeed::whereRaw('status = ? AND category_id = ?', array(true, $category_id))
            ->skip($skip)
            ->take($limit)
            ->get();
        
        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }
}