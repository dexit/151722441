<?php

namespace DLNLab\Features\Classes;

use Auth;
use Input;
use Response;
use Validator;
use Controller as BaseController;
use October\Rain\Support\ValidationException;
use System\Models\File;

require('HelperResponse.php');

class RestAd extends BaseController {
    
    public function postUpload() {
        //if (!Auth::check())
            //return null;
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
    
}