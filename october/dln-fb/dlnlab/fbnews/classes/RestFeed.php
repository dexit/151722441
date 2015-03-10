<?php

namespace DLNLab\FBNews\Classes;

use Auth;
use DB;
use Carbon;
use Input;
use Response;
use Illuminate\Routing\Controller as BaseController;
use DLNLab\FBNews\Models\FbFeed;
use Symfony\Component\DomCrawler\Crawler;

class RestNews extends BaseController {
	
	public static $params = null;
    public static $limit_crawl_ad_active = 100;
    public static $limit_crawl_tag_count = 10;
    
    public function getFeeds() {
        $data = get();
        
        $default = array(
            'category_id' => 0,
            'page' => 0
        );
        extract(array_merge($default, $data));
        
        $limit = DLN_LIMIT;
        $skip  = $page * $limit;
        
        if (! empty($category_id) ) {
            $records = FbFeed::whereRaw('status = ? AND category_id = ?', array(true, $category_id))
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($limit)
            ->get();
        } else {
            $records = FbFeed::whereRaw('status = ?', array(true))
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($limit)
            ->get();
        }
        
        
        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }
}