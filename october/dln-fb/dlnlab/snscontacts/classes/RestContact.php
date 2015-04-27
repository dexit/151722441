<?php
namespace DLNLab\SNSContacts\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\SNSContacts\Helpers\SNSContactsHelper;
use RainLab\User\Models\Settings as UserSettings;
use DLNLab\SNSContacts\Models\Location;
use Validator;
use User;
use Auth;

/**
 * Restful for User api.
 *
 * @author dinhln
 * @since 27/04/2015
 */
class RestContact extends BaseController
{

    /**
     * API function for add new contact.
     * 
     * @return multitype:
     */
    public function postContact() 
    {
        $data = post();

        // Validator post params
        $valids = Validator::make($data, [
            'name' => 'required|min:4|max:32',
            'phone' => 'required|numeric|min:1',
            'address' => 'required',
            'category_id' => 'required|numeric|min:1',
            'lat' => 'required|regex:/^[+-]?\d+\.\d+, ?[+-]?\d+\.\d+$/',
            'lng' => 'required|regex:/^[+-]?\d+\.\d+, ?[+-]?\d+\.\d+$/'
        ], SNSContactHelper::getMessages());
        
        // Check exists error messages
        if ($valids->fails()) {
            return SNSContactsHelper::getErrorMsg($valids->messages());
        }
        
        // Check location and insert to db
        $location = Location::addLocationByLatLng($data);
        
        // Get category name
        $category = Category::find($category_id);
        
        // Build full-text-search
        $fulltexts = array($name, $phone, $address, $location->province, $location->district, $location->ward, $category->name);
        if (isset($data['tags']) && ! empty($data['tags'])) {
            $fulltexts = array_merge($fulltexts, array_splice(explode(',', $data['tags']), SNSC_TAGS_COUNT));
        }
        $fulltext = SNSContactsHelper::buildFullTextSearch($fulltexts);
        
        return array();
    }
    
}
