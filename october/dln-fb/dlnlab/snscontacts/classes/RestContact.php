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
        ], SNSContactsHelper::getMessage());
        
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
    
    /**
     * Api functin for listing contacts.
     * 
     * @return Response
     */
    public function getContacts()
    {
        $data = get();
        
        // Validator get params.
        $valids = Validator::make($data, [
            'page' => 'numeric',
            'order' => 'alpha'
        ], SNSContactsHelper::getMessage());
        
        // Check exists error message.
        if ($valids->fails()) {
            return Response::json(array('status' => 'error', 'data' => $valids->messages()), 500);
        }
        
        extract($data);
        
        // Set default params.
        $page = (isset($page)) ? $page : 0;
        $order = (isset($order)) ? $order : 'all';
        
        // For paging
        $limit = SNSC_PAGINATE;
        $skip  = $page * $limit;
        
        $records = Contact::whereRaw('status = ?', array(true))
            ->take($limit)
            ->skip($skip);
        
        return Response::json(array('status' => 'success', 'data' => $records->get()));
    }
    
    /**
     * Api function for get contact detail.
     * 
     * @param number $id
     * @return Response
     */
    public function getContactDetail($id = 0)
    {
        // Validator contact id.
        $valids = Validator::make([
            'id' => $id
        ], [
            'id' => 'required|min:1'
        ], SNSContactsHelper::getMessage());
        
        // Check validator
        if ($valids->fails())
        {
            return Response::json(array('status' => 'error', 'data' => $valids->messages()), 500);            
        }
        
        // Get contact detail
        $record = Contact::whereRaw('id = ? AND status = ?', array($id, true))
            ->get();
        
        return Response::json(array('status' => 'success', 'data' => $record));
    }
    
}
