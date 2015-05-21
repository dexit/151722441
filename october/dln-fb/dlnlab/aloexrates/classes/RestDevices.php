<?php namespace DLNLab\AloExrates\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\AloExrates\Models\Devices;
use DLNLab\ALoExrates\Helpers\EXRHelper;
use Response;
use Validator;
use Input;

/**
 * Restful for Device api.
 *
 * @author dinhln
 * @since 02/05/2015
 */
class RestDevices extends BaseController
{

    /**
     * API function for register device.
     *
     * @return Response
     */
    public function postRegisterDevice()
    {
        $data = Input::all();

        // Validator for post params
        $valids = Validator::make($data, [
            'device_id' => 'required|alpha_dash',
            'gcm_reg_id' => 'alpha_dash',
            'phone_number' => 'numeric'
        ]);

        extract($data);

        // Check is valid
        if ($valids->fails())
        {
            return Response::json(array('status' => 'Error', $valids->messages()));
        }

        // Check device_id exists in db
        $record = Devices::where('device_id', '=', $device_id)->first();
        if (empty($record)) {
            $record = new Devices;
            $record->device_id = $device_id;
            $record->gcm_reg_id = $gcm_reg_id;
            $record->save();
        }

        return Response::json(array('status' => 'Success', 'data' => $record));
    }

}
