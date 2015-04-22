<?php
namespace DLNLab\SNSContacts\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\SNSContacts\Helpers\SNSContactsHelper;
use DLNLab\SNSContacts\Models\Location;
use Response;

/**
 * Restful for User api.
 * 
 * @author dinhln
 * @since  22/04/2015
 */
class RestLocation extends BaseController
{
    
    /**
     * Get location by latitude longitude.
     * 
     * @param string $lat
     * @param string $lng
     * @return json
     */
    public function getLocationByLatLng($lat = '', $lng = '') {
        $data = array(
            'lat' => $lat,
            'lng' => $lng
        );
        
        if (! $lat || ! $lng || ! ($result = Location::addLocationByLatLng($data))) {
            Response::json(array('status' => 'error', 'data' => 'Error'), 500);
        }
        
        return Response::json(array('status' => 'success', 'data' => $result), 200);
    }
    
}
