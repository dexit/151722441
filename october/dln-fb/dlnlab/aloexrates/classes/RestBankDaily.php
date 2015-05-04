<?php namespace DLNLab\AloExrates\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\AloExrates\Models\BankDaily;
use DLNLab\ALoExrates\Helpers\EXRHelper;
use Response;
use Validator;

/**
 * Restful for Device api.
 *
 * @author dinhln
 * @since 04/05/2015
 */
class RestBankDaily extends BaseController
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
