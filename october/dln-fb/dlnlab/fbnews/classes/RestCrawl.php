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

class RestCrawl extends BaseController
{

    public static $params = null;
    public static $limit_crawl_ad_active = 100;
    public static $limit_crawl_tag_count = 10;

    public function getUpdateFBPageInfor()
    {
        $records = FbPage::whereRaw('status = ? AND crawl = ?', array(true, false))->take(100)->get();
        if (!count($records)) {
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

    public function getFBPageLinks()
    {
        $records = FbPage::whereRaw('status = ? AND crawl = ?', array(true, false))->take(5)->get();
        if (!count($records)) {
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

    /*public function getPageSpec($page_id)
    {
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
    }*/

    /*public function deleteFeedSpec($page_id)
    {
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
    }*/

    public function getFeedExpired()
    {
        $timestamp = \Carbon\Carbon::now()->subWeeks(2)->toDateTimeString();
        $records = FbFeed::whereRaw('created_at < NOW() - INTERVAL ? WEEK', array(DLN_LIMIT_WEEK))->delete();
        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }

    public function getPostFBPage()
    {
        $record = FbFeed::whereNull('shared')
            ->select(DB::raw('id, fb_id, message, picture, category_id, type, source, object_id, created_at, DATE(created_at) AS per_day'))
            ->orderBy('per_day', 'DESC')
            ->orderBy('like_count', 'DESC')
            ->first();

        if (! $record) {
            return Response::json(array('status' => 'error', 'data' => 'Error'), 500);
        }

        $result = new \stdClass();
        $result->message = $record->message;
        $result->link = FbPage::get_feed_infor($record->fb_id);
        //$result->original_link = HelperNews::genBitly($record->link);
        $result->original_link = $record->link;
        $result->type = $record->category->name;

        $tag = strtolower(trim(str_replace(' ', '_', $result->type)));
        $message = $record->message .
            "\n\n\nLink gốc: " . $result->original_link .
            "\nNhóm: " . TAG . $tag;

        $attachment =  array(
            'access_token' => PAGE_TOKEN,
            'message' => $message,
            'link' => $result->link
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,FbPage::$api_url . PAGE_ID . "/feed");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output
        $post = curl_exec($ch);
        curl_close ($ch);

        $post = json_decode($post);
        if (! empty($post->id)) {
            $record->shared = $post->id;
            $record->save();
        }

        return Response::json(array('status' => 'success', 'data' => $result), 200);
    }

    public function getSpamCommentPage() {
        $record = FbPage::whereRaw('status = ? AND crawl_fb = ?', array(true, false))->first();
        if (! $record) {
            FbPage::where('crawl_fb', '=', true)->update(['crawl_fb' => false]);
            $record = FbPage::whereRaw('status = ? AND crawl_fb = ?', array(true, false))->first();
        }

        if (! empty($record->fb_id)) {

            // Get post of current page
            //$records = FbFeed::whereRaw('status = ? AND page_id = ? AND per_day = CURDATE() AND comment_count > ? AND type = ? AND spam IS NULL', [true, $record->id, LIMIT_COMMENT_COUNT, 'link', null])
            $feeds = FbFeed::whereRaw('status = ? AND page_id = ? AND DATE(created_at) = CURDATE() AND type = ? AND spam IS NULL', [true, $record->id, 'link'])
                ->select(DB::raw('id, fb_id, fb_link, name, message, picture, page_id, category_id, like_count, comment_count, share_count, type, source, object_id, created_at, DATE(created_at) AS per_day'))
                ->orderBy('per_day', 'DESC')
                ->orderBy('comment_count', 'DESC')
                ->take(10)
                ->get();

            if (count($feeds)) {
                // Get hot news
                //$feeds = FbFeed::getHotFeeds($record->id, 2);
                /*if (count($feeds)) {
                    foreach ( $records as $record ) {
                        if ($record->fb_id != ) {
                            HelperNews::postCommentToFB($record->fb_id, $record->link, $record->name);
                        }

                    }
                }*/
                $last = count($feeds) - 1;
                if ($last >= 1) {
                    foreach ($feeds as $i => $feed) {
                        if ($last - $i != $i) {
                            $feed->spam = HelperNews::postCommentToFB($feed->fb_id, $feeds[$last - $i]->fb_link, $feeds[$last - $i]->name);
                            $feed->save();
                            $record->crawl_fb = true;
                            $record->save();
                        }
                    }
                }
            }
        }

        return Response::json(array('status' => 'success', 'data' => $feeds), 200);
    }

}