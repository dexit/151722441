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
class RestVote extends BaseController
{

    public function postAddVote() {
        $data = post();
        $default = array(
            'device_id' => '',
            'fb_id' => ''
        );
        extract(array_merge($default, $data));

        if (empty($device_id) || empty($fb_id)) {
            return Response::json(array('status' => 'error', 'data' => 'Error'), 500);
        }
    }

}
