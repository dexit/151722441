<?php
namespace DLNLab\AloExrates\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\AloExrates\Models\Notification;
use DLNLab\ALoExrates\Helpers\EXRHelper;
use Response;
use Validator;

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
    public function postRegisterFollow()
    {
        $data = post();
        
        // Valid post params.
        $valids = Validator::make($data, [
            'type' => 'required_if:type,device,facebook',
            'sender_id' => 'required',
            'is_min' => 'boolean',
            'is_max' => 'boolean'
        ], EXRHelper::getMessage());
        
        // Check validator.
        if ($valids->fails())
        {
            return Response::json(array('status' => 'error', 'data' => $valids->messages()));
        }
        
        $record = Notification::updateConditions($data);
        
        return Response::json(array('success' => 'Success', 'data' => $record));
    }
    
    /**
     * Api function for add notification currency.
     * 
     * @return Response
     */
    public function postAddNotificationCurrency()
    {
        $data = post();
        
        // Valid post params.
        $valids = Validator::make($data, [
            'sender_ids'   => 'required',
            'currency_ids' => 'required'
        ], EXRHelper::getMessage());
        
        // Check validator.
        if ($valids->fails())
        {
            return Response::json(array('status' => 'error', 'data' => $valids->messages()));
        }
        
        $senderIds   = explode(',', $data['sender_ids']);
        $senderIds   = array_slice($senderIds, 2);
        $currencyIds = explode(',', $data['currency_ids']);
        
        foreach ($senderIds $as $sId)
        {
            // Check limit number notification per account
            
            
            foreach ($currencyIds as $cId)
            {
                $cId = intval($cId);
            
                if (! $cId)
                {
                    
                }
            }
        }
        
        return Response::json();
    }
}
