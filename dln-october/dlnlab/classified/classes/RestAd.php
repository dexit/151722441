<?php

namespace DLNLab\Classified\Classes;

use Auth;
use Input;
use Response;
use Validator;
use Controller as BaseController;
use October\Rain\Support\ValidationException;
use System\Models\File;
use DLNLab\Classified\Models\AdActive;

require('HelperResponse.php');

class RestAd extends BaseController {
    
    public function postUpload() {
        if (!Auth::check())
            return null;
        
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
            return null;
        
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
    
    public function getSearch() {
        $q = Input::get('query');
        
        if (! $q)
            return null;
        
        $ads = Ad::whereRaw('MATCH(full_text) AGAINST(? IN BOOLEAN MODE)', array($q))->take(100)->get();
        
        return Response::json($ads->toJson());
    }
    
}