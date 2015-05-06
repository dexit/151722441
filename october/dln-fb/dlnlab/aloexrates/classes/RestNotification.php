<?php
namespace DLNLab\AloExrates\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\AloExrates\Models\Notification;
use DLNLab\AloExrates\Models\NotificationCurrency;
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
        
        foreach ($senderIds as $sId)
        {
            foreach ($currencyIds as $cId)
            {
                $cId = intval($cId);
            
                if (! $cId)
                {
                    $record = NotificationCurrency::whereRaw('sender_id = ? AND currency_id = ?', array($sId, $cId))->first();
                    if (! $record) {
                        $record = new NotificationCurrency();
                        $record->sender_id = $sId;
                        $record->currency_id = $cId;
                        $record->save();
                    }
                }
            }
        }
        
        return Response::json(array('status' => 'Success', 'data' => true));
    }
}
