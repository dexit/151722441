<?php namespace DLNLab\AloExrates;

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
            'device_id' => 'required'
        ]);

        // Check is valid
        if ($valids->fails()) {
            return EXRHelper::getErrorMsg($valids->messages());
        }

        $result = Devices::addDevice($data['device_id']);

        return EXRHelper::getSuccess($result);
    }

}
