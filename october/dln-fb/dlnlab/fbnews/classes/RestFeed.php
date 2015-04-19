<?php

namespace DLNLab\FBNews\Classes;

use Auth;
use DB;
use Carbon;
use Cache;
use Input;
use Response;
use Redirect;
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

    public function getFeedByIds() {
        $data = get();

        $default = array(
            'feed_ids' => ''
        );
        extract(array_merge($default, $data));

        if (empty($feed_ids)) {
            return Response::json(array('status' => 'error', 'data' => 'Error'), 500);
        }

        $arr_ids = array();
        if (is_string($feed_ids)) {
            $arr_ids_old = explode(',', $feed_ids);
            if (count($arr_ids_old)) {
                foreach ($arr_ids_old as $item) {
                    if (intval($item) > 0 && ! in_array($item, $arr_ids)) {
                        $arr_ids[] = $item;
                    }
                    if (count($arr_ids) > DLN_LIMIT) {
                        break;
                    }
                }
            }
        }

        $records = FbFeed::whereRaw('status = ?', array(true))
            ->whereIn('id', $arr_ids)
            ->select(DB::raw('id, fb_id, name, message, picture, page_id, category_id, like_count, comment_count, share_count, type, source, object_id, created_at, DATE(created_at) AS per_day'))
            ->orderBy('per_day', 'DESC')
            ->get()
            ->toArray();

        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }
    
    public function getFeeds() {
        $data = get();
        
        $default = array(
            'category_ids' => '',
            'page_id' => 0,
            'page' => 0,
            'clear_cache' => 0,
            'order' => 'new'
        );
        extract(array_merge($default, $data));

        $arr_cats = array();
        if (is_string($category_ids)) {
            $arr_cats_old = explode(',', $category_ids);
            if (! is_array($arr_cats_old) && empty($arr_cats_old)) {
                return Response::json(array('status' => 'error', 'data' => 'Error'), 500);
            }
            foreach ($arr_cats_old as $i => $item) {
                $item = intval($item);
                if (! in_array($item, $arr_cats) && ! empty($item)) {
                    $arr_cats[] = $item;
                }
            }
        }
        
        $limit = DLN_LIMIT * 10;
        $index = (int) ($page / 10);
        $pos   = (int) ($page % 10);
        $skip  = $index * $limit;

        sort($arr_cats);
        $category_path = implode('_', $arr_cats);

        switch ($order) {
            case 'share':
                $order_by = 'share_count';
                break;
            case 'comment':
                $order_by = 'comment_count';
                break;
            case 'like':
                $order_by = 'like_count';
                break;
            case 'new':
            default:
                $order_by = 'created_at';
                break;
        }

        $cache_id = md5("{$order_by}_{$category_path}_{$page_id}_{$index}");
        if (! empty($clear_cache)) {
            Cache::forget($cache_id);
        }

        if (! Cache::has($cache_id)) {
            if ($page_id) {
                $_cond = 'status = ? AND page_id = ?';
                $_cona = array(true, $page_id);
            } else {
                $_cond = 'status = ? AND like_count > ?';
                $_cona = array(true, ALLOW_LIKE);
            }

            if (! empty($arr_cats) ) {
                $records = FbFeed::whereRaw($_cond, $_cona)
                    ->whereIn('category_id', $arr_cats)
                    ->select(DB::raw('id, fb_id, name, message, picture, page_id, category_id, like_count, comment_count, share_count, type, source, object_id, created_at, DATE(created_at) AS per_day'))
                    ->orderBy('per_day', 'DESC')
                    ->orderBy($order_by, 'DESC')
                    ->skip($skip)
                    ->take($limit)
                    ->get()
                    ->toArray();
            } else {
                $records = FbFeed::whereRaw($_cond, $_cona)
                    ->select(DB::raw('id, fb_id, name, message, picture, page_id, category_id, like_count, comment_count, share_count, type, source, object_id, created_at, DATE(created_at) AS per_day'))
                    ->orderBy('per_day', 'DESC')
                    ->orderBy($order_by, 'DESC')
                    ->skip($skip)
                    ->take($limit)
                    ->get()
                    ->toArray();
            }

            Cache::put($cache_id, json_encode($records), DLN_CACHE_MINUTE);
        } else {
            $records = json_decode(Cache::get($cache_id));
        }

        $records = array_slice($records, $pos * DLN_LIMIT, DLN_LIMIT);
        
        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }
    
    public function getFbCategory() {
        $records = FbCategory::all();
        
        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }

}