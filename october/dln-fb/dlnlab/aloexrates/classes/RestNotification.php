<?php
namespace DLNLab\AloExrates\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\AloExrates\Models\Notification;
use DLNLab\AloExrates\Models\NotificationCurrency;
use DLNLab\ALoExrates\Models\Devices;
use DLNLab\ALoExrates\Helpers\EXRHelper;
use Response;
use Validator;
use Input;

/**
 * Restful for Follow api.
 *
 * @author dinhln
 * @since 04/05/2015
 */
class RestNotification extends BaseController
{
    /**
     * Api function for register new follow.
     * 
     * @return Response
     */
    public function postRegisterNotification()
    {
        $data = Input::all();
        
        // Valid post params.
        $valids = Validator::make($data, [
            'type'        => 'required',
            'reg_id'      => 'required',
            'is_min'      => 'required|boolean',
            'is_max'      => 'required|boolean',
            'currency_id' => 'required|numeric|min:1'
        ], EXRHelper::getMessage());
        
        // Check validator.
        if ($valids->fails())
        {
            return Response::json(array('status' => 'error', 'data' => $valids->messages()));
        }
        
        $record = Notification::updateConditions($data);
        
        return Response::json(array('success' => 'Success', 'data' => $record));
    }

    public function testNtfs()
    {
        var_dump(\Carbon\Carbon::now()->toDateTimeString());die();

        $records = Devices::all();

        $regIds = $records->lists('gcm_reg_id');

        $result = Notification::sendNtfsToDevices('test message', $regIds);

        return Response::json(array('status' => 'success', 'data' => $result));
    }
}
