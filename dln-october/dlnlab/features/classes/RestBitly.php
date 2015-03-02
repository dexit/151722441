<?php

namespace DLNLab\Features\Classes;

use Auth;
use DB;
use Input;
use Response;
use Illuminate\Routing\Controller as BaseController;
use DLNLab\Features\Models\Bitly;

class RestBitly extends BaseController {
	
	public static $bitly_key = '';
    
    public function postBitlyLink() {
        if (! Auth::check())
            return Response::json(array('status' => 'error', 'message' => trans(CLF_LANG_MESSAGE . 'require_signin')), 500);
        
        $message = 'Success';
        $code    = 200;
        $data    = post();
        $default = array(
            'link' => ''
        );
        $merge = array_merge($default, $data);
        $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
        extract($merge);
        
        if ($link) {
            $md5 = md5($link);
            $record = Bitly::where('md5', '=', $md5)->first();
            if (! $record) {
                $record = new Bitly;
                $record->md5  = $md5;
                $record->link = $link;
                $record->save();
            }
        }
        return Response::json($record);
    }
}