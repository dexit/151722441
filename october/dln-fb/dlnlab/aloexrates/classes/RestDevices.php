<?php namespace DLNLab\AloExrates\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\AloExrates\Models\Devices;
use DLNLab\ALoExrates\Helpers\EXRHelper;
use Response;
use Validator;

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
        $data = post();

        // Validator for post params
        $valids = Validator::make($data, [
            'device_id' => 'required',
            'phone_number' => 'numeric'
        ]);

        // Check is valid
        if ($valids->fails())
        {
            return Response::json(array('status' => 'Error', $valids->messages()));
        }

        // Get device object
        $result = Devices::addDevice($data['device_id']);

        return Response::json(array('status' => 'Success', $result));
    }

}
