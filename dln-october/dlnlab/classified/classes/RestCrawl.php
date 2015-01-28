<?php

namespace DLNLab\Classified\Classes;

use Auth;
use DB;
use Cache;
use Carbon;
use Input;
use Response;
use Controller as BaseController;
use DLNLab\Classified\Models\Ad;
use DLNLab\Classified\Models\AdActive;
use DLNLab\Classified\Models\Tag;
use DLNLab\Classified\Models\UserAccessToken;
use DLNLab\Classified\Models\AdShare;
use DLNLab\Classified\Models\AdSharePage;
use DLNLab\Classified\Models\AdShareCount;
use Symfony\Component\DomCrawler\Crawler;

class RestCrawl extends BaseController {
	
	public static $params = null;
    public static $limit_crawl_ad_active = 100;
    public static $limit_crawl_tag_count = 10;
	
	public function getAdDeactive() {
		// Get all ad actived
		$arr_ids = array();
		$records = AdActive::where('status', '=', 1)->take(self::$limit_crawl_ad_active)->get();
		if ($records->count()) {
			$now = Carbon::now();
			foreach ($records as $record) {
				$created = new Carbon($record->created_at);
				if ($created->diff($now)->days >= $record->day) {
					$arr_ids[] = $record->ad_id;
				}
			}
			if (count($arr_ids)) {
                DB::beginTransaction();
                try {
                    Ad::whereIn('id', $arr_ids)->update(array('status' => 0));
                    AdActive::whereIn('ad_id', $arr_ids)->update(array('status' => 0));
                } catch (Exception $ex) {
                    DB::rollback();
                }
				DB::commit();
			}
		}
		var_dump($arr_ids);
        return Response::json(array('status' => 'Success'), 200);
	}
	
	public function getRefreshTagCount() {
		// Get tags
		$tags = Tag::where('crawl', '=', false)->take(self::$limit_crawl_tag_count)->get();
		if (!$tags->count()) {
			// Reset crawl status for all tags
			Tag::all()->update(array('crawl' => false));
            return Response::json(array('status' => 'Error'), 500);
        }

        foreach ($tags as $tag) {
            if ($tag->id)  {
                // Count ad for tag
                $count      = DB::table('dlnlab_classified_ads_tags')->where('tag_id', '=', $tag->id)->count();
                $tag->count = $count;
                $tag->crawl = true;
                $tag->save();
            }
        }
		return Response::json(array('status' => 'Success'), 200);
	}
    
    public function getAdShareStatusCrawl() {
        // Get AdShare active
        $records = AdShare::whereRaw('status = ? AND is_read = ?', array(1, true))->take(100)->get();
        if (! count($records)) {
            //AdShare::all()->update(array('is_read' => false));
            return Response::json(array('status' => 'Error'), 500);
        }
        
        // Get user access tokens
        $arr_uids = array();
        foreach ($records as $record) {
            $arr_uids[] = $record->user_id;
        }
        $access_tokens = UserAccessToken::whereIn('user_id', $arr_uids)->get();
        if (! count($access_tokens))
            return Response::json(array('status' => 'Error'), 500);
        
        // Get App access token
        $api_url = UserAccessToken::$api_url;
        
        foreach ($records as $record) {
            // Get fb id
            switch ($record->share_type) {
                case 'facebook':
                    $fb_id = $record->share_id;
                    if ($fb_id) {
                        foreach ($access_tokens as $item) {
                            if ($item->user_id == $record->user_id && $item->type == 'facebook') {
                                $count_like    = $record->count_like;
                                $count_comment = $record->count_comment;
                                $like    = AdShare::get_like_count($fb_id, $item->access_token);
                                $comment = AdShare::get_comment_count($fb_id, $item->access_token);
                                if ($count_like != $like || $count_comment != $comment) {
                                    $record->count_like    = $like;
                                    $record->count_comment = $comment;
                                    $record->total_count   = $like + $comment;
                                    $record->is_read       = false;
                                    $record->save();
                                }
                            }
                        }
                    }
                    break;
            }
        }
        
        return Response::json(1);
    }
    
    public function getAdSharePage() {
        $records = AdShare::whereRaw('status = ? AND crawl = ?', array(true, false))->take(100)->get();
        if (! count($records)) {
            AdShare::all()->update(array('crawl' => false));
            return Response::json(array('status' => 'Error'), 500);
        }
        
        foreach ($records as $record) {
            if ($record->fb_id) {
                $link = "https://www.facebook.com/" . $record->fb_id;
                UserAccessToken::get_fb_page_infor($AdSharePage['fb_link']);
                $record->crawl = true;
                $record->save();
            }
        }
        
        return Response::json(array('status' => 'Success'), 200);
    }
    
    public function getAdShareCount() {
        $records = AdShareCount::whereRaw('status = ? AND crawl = ?', array(1, false))->take(100)->get();
        if (! count($records)) {
            AdShareCount::all()->update(array('crawl' => false));
            return Response::json(array('status' => 'Error'), 500);
        }
        
        $continue = true;
        foreach ($records as $record) {
            if ($record->ad_id) {
                if ($continue) {
                    $link = Ad::get_ad_link($record->ad_id);
                
                    if (!isset($obj->Facebook)) {
                        $continue = false;
                        return false;
                    }
                    $obj = AdShareCount::get_obj_share_count($link);
                    $record->share_count   = $obj->Facebook->share_count;
                    $record->comment_count = $obj->Facebook->comment_count;
                    $record->like_count    = $obj->Facebook->like_count;
                    $record->gp_count      = $obj->GooglePlusOne;
                    $record->tw_count      = $obj->Twitter;
                    $record->pin_count     = $obj->Pinterest;
                    $record->crawl         = true;
                    $record->save();
                }
            }
        }
        
        return Response::json(array('status' => 'Success'), 200);
    }
}