<?php

namespace DLNLab\FBNews\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\FBNews\Models\FbPage;

/**
 * Description of RestPage
 *
 * @author dinhln
 */
class RestPage extends BaseController {
    
    public function postPage() {
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
            $obj = FbPage::get_fb_profile_infor($fb_link);
        } else {
            $obj = FbPage::get_fb_page_infor($fb_link);
        }
        
        if (empty($obj))
            return Response::json(array('status' => 'error'), 500);
        
        return Response::json(array('status' => 'success', 'data' => $obj), 200);
    }
    
}
