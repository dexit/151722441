<?php

namespace DLNLab\AloExrates\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\AloExrates\Models\Currency;
use DLNLab\AloExrates\Models\CurrencyDaily;
use DLNLab\ALoExrates\Helpers\EXRHelper;
use Response;
use Validator;

/**
 * Restful for Device api.
 *
 * @author dinhln
 * @since 02/05/2015
 */
class RestCrawl extends BaseController
{
    /**
     * Api function for crawl golds.
     * 
     * @return Response
     */
    public function getGoldDaily()
    {
        $apies = json_decode(EXR_GOLDS);
        
        // Crawl bank api url.
        foreach ($apies as $type => $url) {
            switch ($type) {
                
                case 'SJC':
                    $content = file_get_contents($url);
                    if (! $content) {
                        return false;
                    }
        
                    $doc = new \DOMDocument();
                    @$doc->loadXML($content);
                    $xpath = new \DOMXpath($doc);
        
                    $items = $xpath->query('//city');
                    $codes = array();
                    foreach ($items as $item) {
                        $codes[] = $item->getAttribute('name');
                    }
        
                    // Get currency by ids
                    $cities = Currency::where('type', 'GOLD')->get();
                    // Get exchange rates over bank api.
                    foreach ($cities as $city) {
                        $codes = explode('|', $city->code);
                        $item = $xpath->query('//city[@name="' . $codes[0] . '"]/item[@type="' . $codes[1] . '"]')->item(0);
                        if ($item) {
                            $currencyId = $city->id;
                            $buy        = $item->getAttribute('buy');
                            $sell       = $item->getAttribute('sell');

                            CurrencyDaily::updateGoldsDaily($currencyId, $buy, $sell, 'gold');
                        }
                    }
        
                    break;
            }
        }
        
        return Response::json(array(
            'status' => 'Success',
            'data' => $apies
        ), 200);
    }

    /**
     * Api function for crawl exrates.
     *
     * @return Response
     */
    public function getExrates()
    {
        $records = Currency::whereRaw('crawl = ? AND type = ?', array(false, 'CURRENCY'))->take(10)->get();
        if (! count($records)) {
            Currency::where('crawl', '=', true)->update(array(
                'crawl' => false
            ));
            $records = Currency::whereRaw('crawl = ? AND type = ?', array(false, 'CURRENCY'))->take(10)->get();
        }
        
        // Crawl data
        foreach ($records as $record) {
            if (CurrencyDaily::updatePriceDaily($record->id, $record->code, 'currency')) {
                $record->crawl = true;
                $record->save();
            }
        }
        
        return Response::json(array(
            'status' => 'success',
            'data' => $records
        ), 200);
    }

    /**
     * Api function for crawl bank daily data.
     *
     * @return Response
     */
    public function getBankDaily()
    {
        $apies = json_decode(EXR_BANKS);
        
        // Crawl bank api url.
        foreach ($apies as $type => $url) {
            switch ($type) {
                
                case 'VCB':
                    $content = file_get_contents($url);
                    if (! $content) {
                        return false;
                    }
                    
                    $doc = new \Domdocument();
                    @$doc->loadxml($content);
                    $xpath = new \Domxpath($doc);

                    $items = $xpath->query('//Exrate');
                    $codes = array();
                    foreach ($items as $item) {
                        $codes[] = $item->getattribute('CurrencyCode');
                    }

                    // get currency by ids
                    $currencies = Currency::getCurrenciesByCodes($codes, $type);

                    // get exchange rates over bank api.
                    if (count($currencies)) {
                        foreach ($currencies as $currency) {
                            $item = $xpath->query('//Exrate[@CurrencyCode="' . $currency->code . '"]')->item(0);

                            $currencyid = $currency->id;
                            $buy = $item->getattribute('Buy');
                            $transfer = $item->getattribute('Transfer');
                            $sell = $item->getattribute('Sell');

                            if ($buy && $transfer && $sell) {
                                CurrencyDaily::updateExratesDaily($currencyid, $buy, $transfer, $sell, 'bank');
                            }
                        }
                    }
                    
                    break;
                    
            }
        }
        
        return Response::json(array(
            'status' => 'Success',
            'data' => $apies
        ), 200);
    }

    /**
     * Api function for crawl send notification to devices.
     * 
     * @return Response
     */
    public function getSendNotificationDevices()
    {
        $data = get();
        
        // Valid get params.
        $valids = Validator::make($data, [
            'type' => 'required_if:type,defice,facebook'
        ], EXRHelper::getMessage());
        
        // Check valid.
        if ($valids->fails())
        {
            return Response::json(array('status' => 'Error', 'data' => $valids->messages()));
        }
        
        // Get Currency
    }

    /**
     * Api function for crawl get min max currency
     *
     * @return Response
     */
    public function getMinMaxCurrency()
    {
        $data = get();

        // Validator get params
        $valids = Validator::make($data, [
            'type' => 'required'
        ], EXRHelper::getMessage());

        // Check valid
        if ($valids->fails()) {
            return Response::json(array('status' => 'error', 'data' => $valids->messages()));
        }

        $record = CurrencyDaily::whereRaw('type = ? AND is_send = ? AND DATE(updated_at) = CURDATE()', array($data['type'], false))->first();

        if (! $record)
        {
            CurrencyDaily::where('is_send', true)->update(array('is_send' => true));
            $record = CurrencyDaily::whereRaw('is_send = ? AND DATE(updated_at) = CURDATE()', array(false))->first();
        }

        // Check is Min|Max in two week
        if (! $record) {
            return Response::json(array('status' => 'error', 'data' => 'Error'));
        }
        $currencyId = $record->currency_id;

        $message = '';
        if (Cache::has('exr_notification_msg_' . $currencyId))
        {
            $message = Cache::get('exr_notification_msg_' . $currencyId);
        } 
        else
        {
            // Get min
            $min = CurrencyDaily::whereRaw('type = ? AND currency_id = ? AND buy < ? AND updated_at >= NOW() - INTERVAL ? WEEK', array($data['type'], $currencyId, $record->buy, EXR_LIMIT_WEEK))
                ->orderBy('buy', 'ASC')
                ->first();

            if (empty($min)) {
                //Get max
                $max = CurrencyDaily::whereRaw('type = ? AND currency_id = ? AND buy > ? AND updated_at >= NOW() - INTERVAL ? WEEK', array($data['type'], $currencyId, $record->buy, EXR_LIMIT_WEEK))
                    ->orderBy('buy', 'DESC')
                    ->first();
            }

            // Only get currency today if exist min or max data
            $newPrice = $record->buy;
            if ($min || $max) {
                $newPrice = CurrencyDaily::getCurrencyToday($currencyId, $record->buy);
            }

            if ($min) {
                $message = sprintf(EXR_MIN_MSG, $record->name, EXR_LIMIT_WEEK, $newPrice);
            } else if ($max) {
                $message = sprintf(EXR_MAX_MSG, $record->name, EXR_LIMIT_WEEK, $newPrice);
            }

            Cache::put('exr_notification_msg_' . $currencyId, $message, EXR_CACHE_MINUTE);
        }
        
        // Return false if not exists message
        if (empty($message))
        {
            return Response::json(array('status' => 'error', 'data' => 'Error'), 500);
        }
        
        // Get 1000 devices
        $records = Notification::whereRaw('currency_id = ? AND type = ? AND is_send = ?', array($currencyId, $data['type'], false))
            ->take(EXR_LIMIT_DEVICES)
            ->get();
        
        if (! count($records))
        {
            // Update is_send for currency when send all devices.
            $record->is_send = true;
            $record->save();
            
            // Clear if crawl end devices.
            Notification::whereRaw('currency_id = ? AND type = ? AND is_send = ? AND DATE(updated_at) != CURDATE()', array($currencyId, 'device', true))
                ->update(array('is_send', false));
        }
        
        // Convert devices registations ids to array.
        $regIds = $records->lists('reg_id');
        
        $response = '';
        if (count($regIds) <= 1000 && ! empty($message))
        {
            // Send to notification to it
            $response = Notification::sendNtfsToDevices($message, $regIds);
        }
        
        return Response::json(array('status' => 'success', 'data' => $response));
    }

    /**
     * Api function for crawl post news to facebook fanpage.
     * 
     * @return Response
     */
    public function getPostToFBDaily()
    {
        // Get list fb ranges.
        $cCodes = json_decode(EXR_FB_RANGES);
        
        // Get list currency ids.
        $records = Currency::whereIn('code', $cCodes)->get();
        
        if (count($records))
        {
            // Get currency type
            $currencyIds = [];
            $goldIds     = [];
            
            foreach ( $records as $item )
            {
                if ($item->code == 'GOLD')
                {
                    $goldIds[] = $item->id;
                }
                else
                {
                    $currencyIds[] = $item->id;
                }
            }
            
            var_dump(Currency::getCurrenciesDetail($goldIds, 'GOLD'));
            var_dump(Currency::getCurrenciesDetail($currencyIds, 'CURRENCY'));
            die();
        }
    }
}
