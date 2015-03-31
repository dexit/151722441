<?php

namespace DLNLab\FBNews\Classes;

use Input;
use Cache;
use Response;
use Illuminate\Routing\Controller as BaseController;
use DLNLab\FBNews\Models\FbVote;

/**
 * Description of RestPage
 *
 * @author dinhln
 */
class RestVote extends BaseController
{

    public function postAddVote() {
        $data = Input::all();
        $default = array(
            'device_id' => '',
            'fb_id' => '',
            'category_id' => 0
        );
        extract(array_merge($default, $data));

        if (empty($device_id) || empty($fb_id)) {
            return Response::json(array('status' => 'error', 'data' => 'Error1'), 500);
        }

        $record = FbVote::whereRaw('device_id = ? AND fb_id = ?', array($device_id, $fb_id))->first();
        if (! empty($record)) {
            return Response::json(array('status' => 'error', 'data' => 'Bạn đã đăng ký fanpage này rồi!'), 500);
        }

        $record = new FbVote();
        $record->device_id = $device_id;
        $record->category_id = $category_id;
        $record->fb_id = $fb_id;
        $record->save();

        return Response::json(array('status' => 'success', 'data' => $record), 200);
    }

}
