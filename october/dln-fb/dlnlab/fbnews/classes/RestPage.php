<?php

namespace DLNLab\FBNews\Classes;

use Cache;
use Response;
use Illuminate\Routing\Controller as BaseController;
use DLNLab\FBNews\Models\FbPage;

/**
 * Description of RestPage
 *
 * @author dinhln
 */
class RestPage extends BaseController
{

    public function postPage()
    {
        $data = post();
        $default = array(
            'fb_link' => '',
            'category_id' => 0,
            'type' => 'page'
        );
        extract(array_merge($default, $data));

        if (empty($fb_link))
            return Response::json(array('status' => 'error'), 500);

        if ($type == 'user') {
            $obj = FbPage::get_fb_profile_infor($fb_link, $category_id);
        } else {
            $obj = FbPage::get_fb_page_infor($fb_link, $category_id);
        }

        if (empty($obj))
            return Response::json(array('status' => 'error'), 500);

        return Response::json(array('status' => 'success', 'data' => $obj), 200);
    }

    public function getPageList() {
        $data = get();

        $default = array(
            'page' => 0,
            'clear_cache' => 0
        );
        extract(array_merge($default, $data));

        $cache_id = 'dln_pages';
        if (! empty($clear_cache)) {
            Cache::forget($cache_id);
        }

        $limit = DLN_LIMIT;
        $skip = (int) $page * $limit;

        if (! Cache::has($cache_id)) {
            $records = FbPage::whereRaw('status = ?', array(true))
                ->skip($skip)
                ->take($limit)
                ->get()
                ->toArray();

            Cache::put($cache_id, json_encode($records), DLN_CACHE_LONG_MINUTE);
        } else {
            $records = json_decode(Cache::get($cache_id));
        }

        return Response::json(array('status' => 'success', 'data' => $records), 200);
    }

    public function getPageDetail($page_id = 0) {
        if (empty($page_id))
            return Response::json(array('status' => 'error', 'data' => 'Error'), 500);

        $data = get();

        $default = array(
            'clear_cache' => 0
        );
        extract(array_merge($default, $data));

        $cache_id = 'dln_page_' . $page_id;
        if (! empty($clear_cache)) {
            Cache::forget($cache_id);
        }

        if (! Cache::has($cache_id)) {
            $record = FbPage::whereRaw('status = ? AND id = ?', array(true, $page_id))->first();
            Cache::put($cache_id, json_encode($record), DLN_CACHE_SHORT_MINUTE);
        } else {
            $record = json_decode(Cache::get($cache_id));
        }

        return Response::json(array('status' => 'success', 'data' => $record), 200);
    }

    public function getSearchPage() {
        $data = get();

        $default = array(
            'q' => ''
        );
        extract(array_merge($default, $data));

        if (empty($q))
            return Response::json(array('status' => 'error', 'data' => 'Error'), 500);

        $result = FbPage::search_fb_pages($q);

        return Response::json(array('status' => 'success', 'data' => $result), 200);
    }

}
