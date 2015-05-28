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
            'device_id' => 'required|alpha_dash',
            'notify_type' => 'required|alpha_dash',
            'currency_id' => 'required|numeric|min:1'
        ], EXRHelper::getMessage());

        // Check validator.
        if ($valids->fails()) {
            return Response::json(array('status' => 'error', 'data' => $valids->messages()));
        }

        extract($data);

        // Find device id by device_id
        $device = Device::where('device_id', $device_id)->first();

        if (! $device) {
            return Response::json(array('status' => 'error', 'data' => Lang::get('dlnlab.aloexrates::message.device_not_exist')));
        }

        // Check limit notification number
        $record = self::whereRaw('device_id = ?', array($device->id))->count();
        if ($record && $record >= EXR_LIMIT_NTFS) {
            return Response::json(array('status' => 'error', 'data' => Lang::get('dlnlab.aloexrates::message.limit_notify')));
        }

        // Check exists reg_id in db.
        $record = self::whereRaw('device_id = ? AND currency_id = ? AND notify_type = ? ', array($device->id, $currency_id, $notify_type))->first();
        $enable = false;
        if ($record) {
            $record->delete();
            $enable = false;
        } else {
            $record = new self;
            $record->device_id = $device->id;
            $record->currency_id = $currency_id;
            $record->notify_type = $notify_type;
            $record->save();
            $enable = true;
        }

        return Response::json(array('success' => 'Success', 'data' => array('state' => $enable)));
    }

    /**
     * Api function for get listing notifications by device id.
     *
     * @return mixed
     */
    public function getNotificationByDeviceId()
    {
        $data = Input::all();

        $valids = Validator::make($data, [
            'device_id' => 'required|alpha_dash'
        ]);

        // Check validator.
        if ($valids->fails()) {
            return Response::json(array('status' => 'error', 'data' => $valids->messages()));
        }

        // Find device id.
        $record = Device::where('device_id', $data['device_id'])->first();

        if (!$record) {
            return Response::json(array('status' => 'error', 'data' => Lang::get('dlnlab.aloexrates::message.device_not_exist')));
        }

        $records = Notification::where('device_id', $record->id)->get()->toArray();

        return Response::json(array('status' => 'successs', 'data' => $records));
    }

    public function testNtfs()
    {
        $records = Devices::all();

        $regIds = $records->lists('gcm_reg_id');

        $result = Notification::sendNtfsToDevices('test message', $regIds);

        return Response::json(array('status' => 'success', 'data' => $result));
    }
}
