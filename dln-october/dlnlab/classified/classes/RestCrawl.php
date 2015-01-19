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
use Symfony\Component\DomCrawler\Crawler;

class RestCrawl extends BaseController {
	
	public static $params = null;
    public static $limit_crawl_ad_active = 100;
    public static $limit_crawl_tag_count = 10;
	
	public function postAdDeactive() {
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
	}
	
	public function postRefreshTagCount() {
		// Get tags
		$tags = Tag::where('crawl', '=', false)->take(self::$limit_crawl_tag_count)->get();
		if (!$tags->count()) {
			// Reset crawl status for all tags
			Tag::where('crawl', '=', true)->update(array('crawl' => false));
		} else {
			foreach ($tags as $tag) {
				if ($tag->id)  {
					// Count ad for tag
					$count      = DB::table('dlnlab_classified_ads_tags')->where('tag_id', '=', $tag->id)->count();
					$tag->count = $count;
					$tag->crawl = true;
					$tag->save();
				}
			}
		}
		return Response::json(1);
	}
    
    public function postAdShareCrawl() {
        // Get AdShare active
        $records = AdShare::whereRaw('status = ? AND is_read = ?', array(true, true))->take(100)->get();
        if (! count($records))
            return Response::json(array('status' => 'Error'), 500);
        
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
            $fb_id = $record->fb_id;
            if ($fb_id) {
                foreach ($access_tokens as $item) {
                    if ($item->user_id == $record->user_id) {
                        $count_like    = $record->count_like;
                        $count_comment = $record->count_comment;
                        $like    = AdShare::get_like_count($fb_id, $item->access_token);
                        $comment = AdShare::get_comment_count($fb_id, $item->access_token);
                        if ($count_like != $like || $count_comment != $comment) {
                            $record->count_like    = $like;
                            $record->count_comment = $comment;
                            $record->is_read       = false;
                            $record->save();
                        }
                    }
                }
            }
        }
        
        return Response::json(1);
    }
}