<?php

namespace DLNLab\Classified\Classes;

use Auth;
use DB;
use Input;
use Response;
use Str;
use Validator;
use Illuminate\Routing\Controller as BaseController;
use October\Rain\Support\ValidationException;
use System\Models\File;
use October\Rain\Database\ModelException;
use DLNLab\Classified\Models\Ad;
use DLNLab\Classified\Models\AdActive;
use DLNLab\Classified\Models\AdFavorite;
use DLNLab\Classified\Models\AdShareCount;
use DLNLab\Classified\Models\AdSharePage;
use DLNLab\Classified\Models\Tag;
use DLNLab\Classified\Classes\HelperClassified;

require('HelperResponse.php');

class RestAd extends BaseController {

    public static function validate_integer($value) {
        return intval($value);
    }

    public function postUpload($id = '') {
        $user = Auth::getUser();
        $record = Ad::whereRaw('id = ? AND user_id = ?', array($id, $user->id))->first();
        if (! $record) {
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'user_not_perm')), 500);
        }
        
        $result = null;
        if (Input::hasFile('file_data')) {
            try {
                $uploadedFile = Input::file('file_data');

                $validationRules = ['max:' . File::getMaxFilesize()];
                $validationRules[] = 'mimes:jpg,jpeg,bmp,png,gif';

                $validation = Validator::make(
                    ['file_data' => $uploadedFile], ['file_data' => $validationRules]
                );

                if ($validation->fails()) {
                    throw new ValidationException($validation);
                }

                if (!$uploadedFile->isValid()) {
                    throw new SystemException('File is not valid');
                }
                $file = new File();
                $file->data = $uploadedFile;
                $file->field = 'ad_images';
                $file->attachment_id = $id;
                $file->attachment_type = 'DLNLab\Classified\Models\Ad';
                $file->is_public = true;
                $file->save();
                $file->thumb = $file->getThumb(250, 250, ['mode' => 'crop']);

                $result = new \stdClass;
                $result->id = $file->id;
            } catch (Exception $ex) {
                $result = $ex->getMessage();
                return Response::json(array('status' => 'error', 'message' => $result), 500);
            }
        }
        
        $result->photo_pattern = '<div id="dln_photo_item_' . $file->id . '" data-id="' . $file->id . '" class="dln-photo-item panel panel-default bg-master-lightest sm-m-b-5 sm-m-l-5 sm-m-r-5">
    <div class="panel-body sm-p-t-10 sm-p-l-5 sm-p-r-5 sm-p-b-10">
        <div class="col-xs-12 col-sm-3 sm-p-l-5 sm-p-r-5">
            <img class="img-thumbnail m-b-5" width="100%" src="' . $file->thumb . '">
        </div>
        <div class="col-xs-12 col-sm-9 sm-p-l-5 sm-p-r-5">
            <textarea placeholder="' . trans(CLF_LANG_LABEL . 'noi_dung') . '" id="dln_photo_desc" class="form-control clearfix m-b-10" required maxlength="500">' . $file->desc . '</textarea>
            <a href="javascript:void(0)" class="dln-up-photo btn btn-sm btn-default pull-left m-r-5" data-original-title="' . trans(CLF_LANG_LABEL . 'len') . '" data-toggle="tooltip"><i class="fs-14 fa fa-arrow-up"></i></a>
            <a href="javascript:void(0)" class="dln-down-photo btn btn-sm btn-default pull-left" data-original-title="' . trans(CLF_LANG_LABEL . 'xuong') . '" data-toggle="tooltip"><i class="fs-14 fa fa-arrow-down"></i></a>
            <a href="javascript:void(0)" class="dln-delete-photo btn btn-sm btn-danger pull-right" data-original-title="' . trans(CLF_LANG_LABEL . 'xoa') . '" data-toggle="tooltip"><i class="fs-14 fa fa-trash-o"></i></a>
        </div>
    </div>
</div>';

        return Response::json(response_message(200, $result));
    }
    
    public function putPhotoOrder($id) {
        // Get current user
        $user = Auth::getUser();
        
        // Kiem tra ad hien tai co dung la cua user hay ko
        $record = Ad::whereRaw('id = ? AND user_id = ?', array($id, $user->id))->first();
        if (! $record) {
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'ad_not_exist')), 500);
        }
        
        $data = put();
        $default = array(
            'photo_ids' => ''
        );
        $merge = array_merge($default, $data);
        $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
        extract($merge);
        
        if (! is_array(photo_ids)) {
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'require_signin')), 500);
        }
        
        $insert_id = array();
        foreach ($photo_ids as $i => $id) {
            if ($id && is_numeric($id) && ! in_array($id, $insert_id)) {
                // Get this file
                File::where('id', '=', $id)->update(array('sort_order' => $i + 1));
                $insert_id[] = $id;
            }
        }
        return Response::json(array('status' => 'success', 'message' => trans(CLF_LANG_MESSAGE . 'ad_photo_saved')));
    }
    
    public function deletePhoto($id, $photo_id) {
        // Get current user
        $user = Auth::getUser();

        if ($file = self::checkAdPhoto($id, $photo_id, $user)) {
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'user_not_perm')), 500);
        }

        $file->delete();
        return Response::json(array('status' => 'success', 'message' => trans(CLF_LANG_MESSAGE . 'ad_photo_removed')));
    }
    
    public function putPhotoDesc($id, $photo_id) {
        // Get current user
        $user = Auth::getUser();

        if ($file = self::checkAdPhoto($id, $photo_id, $user)) {
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'user_not_perm')), 500);
        }
        
        $data = put();
        $default = array(
            'title' => '',
            'description' => '',
        );
        $merge = array_merge($default, $data);
        $merge = HelperClassified::trim_value($merge);
        extract($merge);

        // Get current user
        $user = Auth::getUser();
        
        if ($file = self::checkAdPhoto($id, $photo_id, $user)) {
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'ad_not_exist')), 500);
        }

        // Cap nhat thong tin title va desc cho photo
        $file->description = str_limit($title, $limit = 500);
        $file->title = str_limit($description, $limit = 125);
        $file->save();

        return Response::json(array('status' => 'success', 'message' => trans(CLF_LANG_MESSAGE . 'ad_photo_saved')));
    }

    private static function checkAdPhoto($id, $photo_id, $user) {
        // Kiem tra ad hien tai co dung la cua user hay ko
        $record = Ad::whereRaw('id = ? AND user_id = ?', array($id, $user->id))->first();
        if (! $record) {
            return false;
        }
        
        $file = File::whereRaw('id = ? AND attachment_id = ? && attachment_type = ?', array($photo_id, $id, 'DLNLab\Classified\Models\Ad'))->first();
        if (! $file) {
            return false;
        }

        return $file;
    }

    public function putActiveAd() {
        $message = 'Success';
        $code = 200;
        $data = post();

        try {
            $user_id = Auth::getUser()->id;

            if (empty($data))
                return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'error_value')), 500);

            $default = array(
                'ad_id' => '',
                'day_type' => '',
            );
            $merge = array_merge($default, $data);
            $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
            extract($merge);

            // Get Ad
            $ad = Ad::find($ad_id);

            if (empty($ad) || !empty($ad->status)) {
                return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'ad_activated')), 500);
            }

            // Get user_id
            $user_id = $ad->user_id;

            if ($_user_id != $user_id) {
                return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'error_user')), 500);
            }

            // Get money and days
            $money = $day = 0;
            AdActive::get_day_type($day_type, $money, $day);
            if (!$money || !$day) {
                return 'Error get day type';
            }

            // Check user money
            $user_money = Money::get_user_charge_money($user_id);
            if (($user_money - $money) < 0) {
                // No active ad when user not enough money
                return 'No active ad when user not enough money';
            }

            DB::beginTransaction();
            try {
                // Minus money
                $o_money = Money::minus_money_user($user_id, $money);

                // Active ad
                $ad->status = 1;
                $ad->published_at = time();
                $ad->save();

                // Update add has activated to DB
                $record = new self;
                $record->ad_id = $ad_id;
                $record->money = $money;
                $record->day = $day;
                $record->status = 1;
                $record->save();
            } catch (Exception $ex) {
                DB::rollback();
                return $ex->getMessage();
            }
            DB::commit();

            return true;

            $message = AdActive::active_ad($data, null, $user_id);
            $message = ($message) ? $message : 'fail';
        } catch (Exception $ex) {
            $code = 403;
            $message = $ex->getMessage();
        }

        return Response::json(response_message($code, $message), $code);
    }

    public function getSearch($query) {
        $data = get();
        $default = array(
            'la_b' => '',
            'ln_b' => '',
            'la_e' => '',
            'ln_e' => '',
            'z' => '',
            'p_min' => '',
            'p_max' => '',
            'l_c_ids' => '',
            'l_k_ids' => '',
            'l_amen_ids' => '',
            'kws' => '',
            'page' => ''
        );
        $merge = array_merge($default, $data);
        $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
        extract($merge);

        $arr_query = null;
        $cons = null;
        $cons[] = ' status = ? ';
        $arr_query[] = 1;

        if (!empty($query)) {
            $query = DB::getPdo()->quote($query);
            $cons[] = " MATCH(full_text) AGAINST({$query} IN BOOLEAN MODE) ";
        }
        if (!empty($la_b)) {
            $cons[] = ' lat >= ? ';
            $arr_query[] = $la_b;
        }
        if (!empty($ln_b)) {
            $cons[] = ' lng >= ? ';
            $arr_query[] = $ln_b;
        }
        if (!empty($la_e)) {
            $cons[] = ' lat <= ? ';
            $arr_query[] = $la_e;
        }
        if (!empty($ln_e)) {
            $cons[] = ' lng <= ? ';
            $arr_query[] = $ln_e;
        }
        if (!empty($p_min)) {
            $cons[] = ' p_min >= ? ';
            $arr_query[] = $p_min;
        }
        if (!empty($p_max)) {
            $cons[] = ' p_max <= ? ';
            $arr_query[] = $p_max;
        }
        if (!empty($l_c_ids) && is_array($l_c_ids)) {
            $l_c_ids = array_map(array($this, 'validate_integer'), $l_c_ids);
            $l_c_ids = implode(',', $l_c_ids);
            $cons[] = " category_id IN ({$l_c_ids}) ";
        }

        $tag_ids = null;
        if (!empty($l_k_ids) && is_array($l_k_ids)) {
            $tag_ids = array_map(array($this, 'validate_integer'), array_merge($tag_ids, $l_k_ids));
        }
        if (!empty($l_amen_ids) && is_array($l_amen_ids)) {
            $tag_ids = array_map(array($this, 'validate_integer'), array_merge($tag_ids, $l_amen_ids));
        }
        if (!empty($tag_ids)) {
            $records = DB::table('dlnlab_classified_ads_tags')->whereIn('tag_id', $tag_ids)->get();
            // Get Ad ids
            $ad_ids = array();
            foreach ($records as $record) {
                if ($record->ad_id) {
                    $ad_ids[] = $record->ad_id;
                }
            }
            $ad_ids = implode(',', $ad_ids);
            $cons[] = " id IN ({$ad_ids}) ";
        }

        $offset = 0;
        if ($page) {
            $page = intval($page);
            if ($page) {
                $offset = $page * 20;
            }
        }

        $cons = implode('AND', $cons);
        $ads = Ad::whereRaw($cons . ' ORDER BY `read` DESC', $arr_query)->select('id', 'name', 'slug', 'price', 'address', 'lat', 'lng', 'read', 'published_at', 'user_id', 'category_id')->take(20)->offset($offset)->get();

        $arr_results = array();
        foreach ($ads as $ad) {
            $obj = new \stdClass;
            $obj = $ad;
            $obj->user = $ad->user->select('id', 'name')->first();
            $arr_results[] = $obj;
        }
        return Response::json($arr_results);
    }

    public function postAdQuick() {
        $data = post();
        $default = array(
            'category_id' => '',
            'type_id' => '1',
            'address' => '',
            'tag_ids' => '',
            'lat' => '',
            'lng' => ''
        );

        $merge = array_merge($default, $data);
        $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
        extract($merge);

        $user = Auth::getUser();

        // Kiem tra user hien tai da > 3 ad draft chua
        $counts = Ad::whereRaw('user_id = ? AND status = 0', array($user->id))->count();
        if ($counts >= CLF_LIMIT_AD_PRIVATE) {
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'not_create_ad')), 500);
        }

        $rules = [
            'category_id' => 'required|numeric|min:1',
            'type_id' => 'required|numeric|min:1',
            'address' => 'required',
            'tag_ids' => 'required|array'
        ];

        // Format lai tag ids
        foreach ($tag_ids as $id) {
            if (!empty($id) || (intval($id) > 0) || (!in_array($id, $tags))) {
                $tags[] = $id;
            }
        }
        if (!count($tags))
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'not_create_ad')), 500);

        $error = valid($rules);
        if ($error != null)
            return Response::json(array('status' => 'error', 'message' => $error), 500);

        $name = Ad::gen_auto_ad_name($data);
        $slug = HelperClassified::slug_utf8($name);

        try {
            DB::beginTransaction();
            $record = new Ad;
            $record->name = $name;
            $record->slug = $slug;
            $record->address = $address;
            $record->category_id = $category_id;
            $record->price = $price;
            $record->lat = $lat;
            $record->lng = $lng;
            $record->save();

            // Them vao bang ads_tags
            $arr_insert = array();
            foreach ($tags as $id) {
                $arr_insert[] = array('ad_id' => $record->id, 'tag_id' => $id);
            }
            DB::table('dlnlab_classified_ads_tags')->insert($arr_insert);

            DB::commit();
            return Response::json(array('status' => 'success', 'data' => $record->id));
        } catch (Exception $ex) {
            DB::rollback();
            return Response::json(array('status' => 'error', 'message' => $error), 500);
        }
    }

    public function putAd($id) {
        if (!Auth::check())
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'require_signin')), 500);

        $data = post();
        try {
            DB::beginTransaction();

            $default = array(
                'name' => '',
                'slug' => '',
                'description' => '',
                'price' => '',
                'address' => '',
                'category_id' => '',
                'tag_ids' => '',
                'lat' => '',
                'lng' => ''
            );
            $merge = array_merge($default, $data);
            $merge = HelperClassified::trim_value($merge);
            extract($merge);

            $record = Ad::find($id);
            if (empty($record) || $record->user_id != Auth::getUser()->id) {
                return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'error_user')), 500);
            }

            $lat = (is_float($lat)) ? floatval($lat) : '';
            $lng = (is_float($lng)) ? floatval($lng) : '';

            $record->name = str_limit($name, $limit = 125);
            $record->slug = (empty($slug)) ? HelperClassified::slug_utf8($name) : $slug;
            $record->description = str_limit($description, $limit = 500);
            $record->price = preg_replace("/[^0-9]/", "", $price);
            $record->address = $address;
            $record->category_id = $category_id;
            $record->lat = $lat;
            $record->lng = $lng;

            if (!$record->validate()) {
                $message = $record->errors()->all();
                return Response::json(array('status' => 'error', 'message_array' => $message), 500);
            }
            $record->save();

            $city = '';
            $state = '';
            if ($lat && $lng) {
                $response = @file_get_contents(sprintf('https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s&language=vi_VN', $lat, $lng));
                $json_resp = json_decode($response);

                if (isset($json_resp->results[0]->address_components) && is_array($json_resp->results[0]->address_components)) {
                    $allow = true;
                    foreach ($json_resp->results[0]->address_components as $i => $component) {
                        if (!empty($component->types) && in_array('country', $component->types) && ($component->short_name != 'VN')) {
                            $allow = false;
                        }
                        if ($allow && !empty($component->types) && in_array('administrative_area_level_1', $component->types)) {
                            $city = $component->short_name;
                        }

                        if ($allow && !empty($component->types) && in_array('administrative_area_level_2', $component->types)) {
                            $state = $component->long_name;
                        }
                    }
                }
            }

            if ($record->id) {
                $default = array(
                    'ad_id' => $record->id,
                    'tag_ids' => $tag_ids,
                    'city_tag' => $city,
                    'state_tag' => $state,
                );
                Tag::save_tag($default);
            }

            DB::commit();

            return Response::json(array('status' => 'success', 'data' => $record));
        } catch (Exception $ex) {
            DB::rollback();
            return Response::json(array('status' => 'error', 'message' => $ex->getMessage()), 500);
        }
    }

    public function putAdInfor($id) {
        if (!Auth::check())
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'require_signin')), 500);
        
        $data = post();
        try {
            DB::beginTransaction();

            $default = array(
                'area' => '0',
                'tier' => '0',
                'direction' => '',
                'bed' => '0',
                'bath' => '0',
            );
            $merge = array_merge($default, $data);
            $merge = HelperClassified::trim_value($merge);
            extract($merge);
            
            $record = Ad::find($id);
            if (empty($record) || $record->user_id != Auth::getUser()->id) {
                return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'error_user')), 500);
            }
            
            $record->area      = intval($area);
            $record->tier      = intval($tier);
            $record->direction = intval($direction);
            $record->bed       = intval($bed);
            $record->bath      = intval($bath);
            $record->save();
            
            DB::commit();

            return Response::json(array('status' => 'success', 'data' => $record));
        } catch (Exception $ex) {
            DB::rollback();
            return Response::json(array('status' => 'error', 'message' => $ex->getMessage()), 500);
        }
    }
    
    public function postShareAd() {
        if (!Auth::check())
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'require_signin')), 500);

        $data = post();
        $default = array(
            'type' => '',
            'page_id' => '',
            'message' => ''
        );
        $merge = array_merge($default, $data);
        $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
        extract($merge);

        require('libraries/BufferApp/buffer.php');
        require('libraries/SocialAutoPoster/SocialAutoPoster.php');
        $autoposter = new \SocialAutoPoster();

        try {
            switch ($type) {
                case 'facebook':
                    $facebook = $autoposter->getApi('facebook', array(
                        'page_id' => '408730579166315',
                        'appid' => '225132297553705',
                        'appsecret' => '8f00d29717ee8c6a49cd25da80c5aad8',
                        'access_token' => 'CAADMwbKfhykBAKj0OCExhhWBIRFJw5K1jRjijq3W4v7vkKgWHk3du1PfRXUtvKpVIcfJrFP32wuzFVpFW7DWlWhbZAz7sMyxhFcGUbJrMDR46tyiOcZAsvbKBoSEO7iymHuCzKgxfmtk0p3MuyRnZAKKCFapZBNGmRzF803pZBUVcZCLCghizLIgTO0mlH65Pk9WbtzXHKZC0uwwZAjMtkCq'
                    ));
                    $facebook->postToWall('Hello FB');
                    var_dump($facebook->getErrors());
                    break;

                case 'googleplus':
                    $client_id = '54c5d3d2a4a87d060fb822b5';
                    $client_secret = 'fa161986339e85b17d71f8d70b25efa9';
                    $callback_url = 'http://localhost/october/api/v1/callback_buffer';

                    $buffer = new \BufferApp($client_id, $client_secret, $callback_url);

                    $profiles = $buffer->go('/profiles');

                    if (is_array($profiles)) {
                        foreach ($profiles as $profile) {
                            $buffer->go('/updates/create', array('text' => 'My first status update from bufferapp-php worked!', 'profile_ids[]' => $profile->id));
                        }
                    }

                    //$gplus = AdSharePage::connect_gplus($autoposter);
                    //AdSharePage::post_gplus_wall($gplus, $page_id, $message);
                    break;
            }
        } catch (Exception $ex) {
            return Response::json(array('status' => $ex->getMessage()), 500);
        }
    }

    public function putAdFavorite($id) {
        if (!Auth::check())
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'require_signin')), 500);

        try {
            // Check exists in DB
            $user_id = Auth::getUser()->id;
            $action = Input::get('action');

            if (empty($id) || empty($user_id))
                return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'ad_not_exist')), 500);

            $state = '';
            $record = AdFavorite::whereRaw('ad_id = ? AND user_id = ?', array($id, $user_id))->first();
            if ($record) {
                if ($action != 'unfavorite') {
                    return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'ad_not_exist')), 500);
                }
                $record->delete();
                $state = 'ad_unfavorite';
            } else {
                if ($action != 'favorite') {
                    return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'ad_not_exist')), 500);
                }
                $record = new AdFavorite;
                $record->ad_id = $id;
                $record->user_id = $user_id;
                $record->save();
                $state = 'ad_favorite';
            }

            return Response::json(array('status' => 'success', 'message' => trans(CLF_LANG_MESSAGE . $state)), 500);
        } catch (Exception $ex) {
            throw $e;
            return Response::json(array('status' => 'error'), 500);
        }
    }

    public function getNearby($id) {
        $data = get();
        $default = array(
            'page' => 0
        );
        $merge = array_merge($default, $data);
        $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
        extract($merge);

        $records = Ad::getNearbyAd($id, $page);

        return Response::json(array('status' => 'success', 'data' => $records));
    }

}
