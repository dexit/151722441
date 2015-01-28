<?php

namespace DLNLab\Classified\Classes;

use Auth;
use DB;
use Input;
use Response;
use Validator;
use Controller as BaseController;
use October\Rain\Support\ValidationException;
use System\Models\File;
use DLNLab\Classified\Models\Ad;
use DLNLab\Classified\Models\AdActive;
use DLNLab\Classified\Models\AdShareCount;
use DLNLab\Classified\Models\AdSharePage;

require('HelperResponse.php');

class RestAd extends BaseController {
    
    public function postUpload() {
        //if (!Auth::check())
        //    return Response::json(array('status' => 'Error'), 500);
        
        $result = null;
        if (Input::hasFile('file_data')) {
            try {
                $uploadedFile = Input::file('file_data');
                
                $validationRules   = ['max:'.File::getMaxFilesize()];
                $validationRules[] = 'mimes:jpg,jpeg,bmp,png,gif';
                
                $validation = Validator::make(
                    ['file_data' => $uploadedFile],
                    ['file_data' => $validationRules]
                );
                
                if ($validation->fails()) {
                    throw new ValidationException($validation);
                }
                
                if (!$file->isValid()) {
                    throw new SystemException('File is not valid');
                }
                $file = new File();
                $file->data = $uploadedFile;
                $file->is_public = true;
                $file->save();
                $file->thumb = $file->getThumb(200, 200, ['mode' => 'crop']);
                $result = $file;
            } catch (Exception $ex) {
                $result = $ex->getMessage();
            }
        }
        
        return Response::json( response_message( 200, $result ));
    }
    
    public function putActiveAd() {
        if (!Auth::check())
            return Response::json(array('status' => 'Error'), 500);
        
        $message = 'Success';
        $code    = 200;
        $data    = post();
        
        try {
            $user_id = Auth::getUser()->id;
            $message = AdActive::active_ad($data, null, $user_id);
            $message = ($message) ? $message : 'fail';
        } catch (Exception $ex) {
            $code   = 403;
            $message = $ex->getMessage();
        }
        
        return Response::json( response_message($code, $message), $code);
    }
    
    public static function validate_integer($value) {
        return intval($value);
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
        extract(array_merge($default, $data));
        
        $arr_query    = null;
        $cons         = null;
        $cons[]       = ' status = ? ';
        $arr_query[]  = 1;
        
        if (! empty($query)) {
            $query  = DB::getPdo()->quote($query);
            $cons[] = " MATCH(full_text) AGAINST({$query} IN BOOLEAN MODE) ";
        }
        if (! empty($la_b)) {
            $cons[] = ' lat >= ? ';
            $arr_query[] = $la_b;
        }
        if (! empty($ln_b)) {
            $cons[] = ' lng >= ? ';
            $arr_query[] = $ln_b;
        }
        if (! empty($la_e)) {
            $cons[] = ' lat <= ? ';
            $arr_query[] = $la_e;
        }
        if (! empty($ln_e)) {
            $cons[] = ' lng <= ? ';
            $arr_query[] = $ln_e;
        }
        if (! empty($p_min)) {
            $cons[] = ' p_min >= ? ';
            $arr_query[] = $p_min;
        }
        if (! empty($p_max)) {
            $cons[] = ' p_max <= ? ';
            $arr_query[] = $p_max;
        }
        if (! empty($l_c_ids) && is_array($l_c_ids)) {
            $l_c_ids = array_map(array($this, 'validate_integer'), $l_c_ids);
            $l_c_ids = implode(',', $l_c_ids);
            $cons[] = " category_id IN ({$l_c_ids}) ";
        }
        
        $tag_ids = null;
        if (! empty($l_k_ids) && is_array($l_k_ids)) {
            $tag_ids = array_map(array($this, 'validate_integer'), array_merge($tag_ids, $l_k_ids));
        }
        if (! empty($l_amen_ids) && is_array($l_amen_ids)) {
            $tag_ids = array_map(array($this, 'validate_integer'), array_merge($tag_ids, $l_amen_ids));
        }
        if (! empty($tag_ids)) {
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
        $ads  = Ad::whereRaw($cons . ' ORDER BY `read` DESC', $arr_query)->select('id', 'name', 'slug', 'price', 'address', 'lat', 'lng', 'read', 'published_at', 'user_id', 'category_id')->take(20)->offset($offset)->get();
        
        $arr_results = array();
        foreach ( $ads as $ad ) {
            $obj = new \stdClass;
            $obj = $ad;
            $obj->user = $ad->user->select('id', 'name')->first();
            $arr_results[] = $obj;
        }
        return Response::json($arr_results);
    }
 
    public function postShareAd() {
        if (! Auth::check())
            return Response::json(array('status' => 'Error'), 500);
        
        $data    = post();
        $default = array(
            'type'    => '',
            'page_id' => '',
            'message' => ''
        );
        extract(array_merge($default, $data));
        
        require('libraries/BufferApp/buffer.php');
        require('libraries/SocialAutoPoster/SocialAutoPoster.php');
        $autoposter = new \SocialAutoPoster();
        
        try {
            switch($type) {
            case 'facebook':
                $facebook = $autoposter->getApi('facebook',array(
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
			var_dump($profiles);die();
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
}