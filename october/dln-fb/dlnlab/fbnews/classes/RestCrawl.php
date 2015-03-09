<?php

namespace DLNLab\FBNews\Classes;

use Auth;
use DB;
use Carbon;
use Input;
use Response;
use Illuminate\Routing\Controller as BaseController;
use DLNLab\FBNews\Models\FbPage;
use Symfony\Component\DomCrawler\Crawler;

class RestCrawl extends BaseController {
	
	public static $params = null;
    public static $limit_crawl_ad_active = 100;
    public static $limit_crawl_tag_count = 10;
    
    public function getUpdateFBPageInfor() {
        $records = FbPage::whereRaw('status = ? AND crawl = ?', array(true, false))->take(100)->get();
        if (! count($records)) {
            FbPage::where('crawl', '=', true)->update(array('crawl' => false));
            return Response::json(array('status' => 'error'), 500);
        }
        
        foreach ($records as $record) {
            if ($record->fb_id) {
                $link = "https://www.facebook.com/" . $record->fb_id;
                FbPage::get_fb_page_infor($link);
                $record->crawl = true;
                $record->save();
            }
        }
        
        return Response::json(array('status' => 'success'), 200);
    }
    
    public function getFBPageLinks() {
        $records = FbPage::whereRaw('status = ? AND crawl = ?', array(true, false))->take(10)->get();
        if (! count($records)) {
            FbPage::where('crawl', '=', true)->update(array('crawl' => false));
            return Response::json(array('status' => 'error'), 500);
        }
        
        foreach ($records as $record) {
            if ($record->fb_id) {
                FbPage::get_fb_feeds($record->fb_id, $record->id, $record->category_id);
                $record->crawl = true;
                $record->save();
            }
        }
    }
}