<?php

namespace DLNLab\FBNews\Classes;

use DB;
use Cache;
use DLNLab\FBNews\Models\FbCategory;
use DLNLab\FBNews\Models\FbPage;
use Illuminate\Routing\Controller as BaseController;
use Response;

class RestCache extends BaseController {

    public function getCacheBasic() {
        $data = get();

        $default = array(
            'clear_cache' => 0
        );
        extract(array_merge($default, $data));

        $cache_id = 'dln_category';
        if (! empty($clear_cache)) {
            Cache::forget($cache_id);
        }
        if (! Cache::has($cache_id)) {
            $category = FbCategory::where('status', '=', true)
                ->select(DB::raw('id, name, description'))
                ->orderBy('name', 'ASC')
                ->get()
                ->toArray();

            Cache::put($cache_id, json_encode($category), DLN_CACHE_CATEGORY);
        } else {
            $category = json_decode(Cache::get($cache_id));
        }

        $cache_id = 'dln_pages';
        if (! empty($clear_cache)) {
            Cache::forget($cache_id);
        }
        if (! Cache::has($cache_id)) {
            $page = FbPage::where('status', '=', true)
                ->select(DB::raw('id, name, fb_id, category_id, like_count, talking_about'))
                ->orderBy('like_count', 'DESC')
                ->get()
                ->toArray();

            Cache::put($cache_id, json_encode($page), DLN_CACHE_PAGE);
        } else {
            $page = json_decode(Cache::get($cache_id));
        }

        $result = new \stdClass();
        $result->category = $category;
        $result->page = $page;

        return Response::json(array('status' => 'success', 'data' => $result), 200);
    }

}