<?php

namespace DLNLab\FBNews\Classes;

use Auth;
use Carbon;
use DB;
use DLNLab\FBNews\Models\FbFeed;
use DLNLab\FBNews\Models\FbPage;
use Illuminate\Routing\Controller as BaseController;
use Input;
use Response;
use Symfony\Component\DomCrawler\Crawler;

class RestCrawl extends BaseController {
	
	public static $params = null;
    public static $limit_crawl_ad_active = 100;
    public static $limit_crawl_tag_count = 10;
    
    public function getUpdateFBPageInfor() {
        $records = FbPage::whereRaw('status = ? AND crawl = ?', array(true, false))->take(100)->get();
        if (! count($records)) {
            FbPage::where('crawl', '=', true)->update(array('crawl' => false));
            $records = FbPage::whereRaw('status = ? AND crawl = ?', array(true, false))->take(100)->get();
        }
        
        foreach ($records as $record) {
            if ($record->fb_id) {
                $link = "https://www.facebook.com/" . $record->fb_id;

                FbPage::get_fb_page_infor($link, $record->category_id, $record->status);
                // Count feed for page
                $count = FbFeed::whereRaw('status = ? AND page_id = ?', array(true, $record->id))->count();
                $record->count = $count;
                $record->crawl = true;
                $record->save();
            }
        }
        
        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }
    
    public function getFBPageLinks() {
        $records = FbPage::whereRaw('status = ? AND crawl = ?', array(true, false))->take(5)->get();
        if (! count($records)) {
            FbPage::where('crawl', '=', true)->update(array('crawl' => false));
            $records = FbPage::whereRaw('status = ? AND crawl = ?', array(true, false))->take(5)->get();
        }
        
        foreach ($records as $record) {
            if ($record->fb_id) {
                FbPage::get_fb_feeds($record->fb_id, $record->id, $record->category_id);
                $record->crawl = true;
                $record->save();
            }
        }

        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }

    public function getPageSpec($page_id) {
        if (empty(intval($page_id)))
            return Response::json(array('status' => 'error', 'data' => 'Error'), 500);

        $record = FbPage::find($page_id);
        $items = null;
        if ($record) {
            $items = FbPage::get_fb_feeds($record->fb_id, $record->id, $record->category_id);
            $record->crawl = true;
            $record->save();
        }

        return Response::json(array('status' => 'success', 'data' => $items), 200);
    }

    public function deleteFeedSpec($page_id) {
        $data = post();
        $default = array(
            'page_id' => 0,
            'token' => ''
        );
        extract(array_merge($default, $data));

        if (empty(intval($page_id)) || $token != DLN_TOKEN)
            return Response::json(array('status' => 'error', 'data' => 'Error'), 500);

        $records = FbFeed::where('page_id', '=', $page_id)->delete();

        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }

    public function getFeedExpired() {
        $timestamp = \Carbon\Carbon::now()->subWeeks(2)->toDateTimeString();
        $records = FbFeed::whereRaw('created_at < NOW() - INTERVAL ? WEEK', array(DLN_LIMIT_WEEK))->delete();
        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }
}