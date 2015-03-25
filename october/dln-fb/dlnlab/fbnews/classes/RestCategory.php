<?php

namespace DLNLab\FBNews\Classes;

use Auth;
use Cache;
use DLNLab\FBNews\Models\FbCategory;
use Illuminate\Routing\Controller as BaseController;
use Response;

class RestCategory extends BaseController {

    public function getCategoryList() {
        $data = get();

        $default = array(
            'page' => 0,
            'clear_cache' => 0
        );
        extract(array_merge($default, $data));

        $cache_id = 'dln_category';
        if (! empty($clear_cache)) {
            Cache::forget($cache_id);
        }

        $limit = DLN_LIMIT;
        $skip = (int) $page * $limit;

        if (! Cache::has($cache_id)) {
            $records = FbCategory::whereRaw('status = ?', array(true))
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

    public function getCategoryDetail($category_id = 0) {

        $data = get();

        $default = array(
            'clear_cache' => 0
        );
        extract(array_merge($default, $data));

        $cache_id = 'dln_category_' . $category_id;
        if (! empty($clear_cache)) {
            Cache::forget($cache_id);
        }

        if (! Cache::has($cache_id)) {
            $record = FbPage::whereRaw('status = ? AND id = ?', array(true, $category_id))->first();
            Cache::put($cache_id, json_encode($record), DLN_CACHE_SHORT_MINUTE);
        } else {
            $record = json_decode(Cache::get($cache_id));
        }

        return Response::json(array('status' => 'success', 'data' => $record), 200);
    }

}