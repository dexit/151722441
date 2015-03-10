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

class RestFeed extends BaseController {
	
	public static $params = null;
    public static $limit_crawl_ad_active = 100;
    public static $limit_crawl_tag_count = 10;
    
    public function getFeedsByPage($page_id = 0) {
        $data = get();
        
        $default = array(
            'page' => 0
        );
        extract(array_merge($default, $data));
        $limit = DLN_LIMIT;
        $skip  = $page * $limit;
        
        $records = FbFeed::whereRaw('status = ? AND page_id = ?', array(true, $page_id))
            ->select(DB::raw('*, DATE(created_at) AS per_day'))
            ->orderBy('per_day', 'DESC')
            ->orderBy('like_count', 'DESC')
            ->skip($skip)
            ->take($limit)
            ->get();
        
        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }
    
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
                ->select(DB::raw('*, DATE(created_at) AS per_day'))
                ->orderBy('per_day', 'DESC')
                ->orderBy('like_count', 'DESC')
                ->skip($skip)
                ->take($limit)
                ->get();
        } else {
            $records = FbFeed::whereRaw('status = ?', array(true))
                ->select(DB::raw('*, DATE(created_at) AS per_day'))
                ->orderBy('per_day', 'DESC')
                ->orderBy('like_count', 'DESC')
                ->skip($skip)
                ->take($limit)
                ->get();
        }
        
        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }
    
    public function getFbCategory() {
        $records = FbCategory::all();
        
        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }
}