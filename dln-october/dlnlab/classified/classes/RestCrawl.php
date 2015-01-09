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
}