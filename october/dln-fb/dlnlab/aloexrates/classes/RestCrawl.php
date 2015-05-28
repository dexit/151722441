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
                    if (!$content) {
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
                            $buy = $item->getAttribute('buy');
                            $sell = $item->getAttribute('sell');

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
        if (!count($records)) {
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
                    if (!$content) {
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
            'token' => 'required|in:' + EXR_TOKEN
        ], EXRHelper::getMessage());

        // Check valid.
        if ($valids->fails()) {
            return Response::json(array('status' => 'Error', 'data' => $valids->messages()), 403);
        }

        // Get Currency
        $currencies = Currency::whereRaw('is_send = ?', array(false))
            ->take(5)
            ->get();

        if (!count($currencies)) {
            Currency::where('is_send', true)->update(array('is_send' => false));
            $currencies = Currency::whereRaw('is_send = ?', array(false))
                ->take(5)
                ->get();
        }

        foreach ($currencies as $currency) {
            $message = $tye = '';
            if (Cache::has('exr_notification_msg_' . $currency->id)) {
                $data    = Cache::get('exr_notification_msg_' . $currency->id);
                $message = isset($data['message']) ? $data['message'] : '';
                $type    = isset($data['type']) ? $data['type'] : '';
            } else {
                // Get today currency
                $today = CurrencyDaily::whereRaw('currency_id = ? AND DATE(created_at) = CURDATE()', array($currency->id))->first();
                if (!$today) {
                    return Response::json(array('status' => 'error', 'data' => 'Error'), 500);
                }

                $mimax = CurrencyDaily::whereRaw('currency_id = ? AND DATE(created_at) >= NOW() - INTERVAL ? WEEK', array($currency->id, EXR_LIMIT_WEEK))
                    ->select(DB::raw('MIN(buy) as min, MAX(buy) as max'))
                    ->first();

                if ($mimax->min > $today->buy) {
                    $message = sprintf(EXR_MIN_MSG, $today->name, EXR_LIMIT_WEEK, $today->buy);
                    $tye = 'currency_min';
                } else if ($mimax->max < $today->buy) {
                    $message = sprintf(EXR_MAX_MSG, $today->name, EXR_LIMIT_WEEK, $today->buy);
                    $type = 'currency_max';
                } else {
                    $message = '';
                    $type = '';
                }

                if ($message) {
                    Cache::put('exr_notification_msg_' . $currency->id, array('message' => $message, 'type' => $type), EXR_CACHE_MINUTE);
                }
            }

            if (!$message) {
                return Response::json(array('status' => 'error', 'data' => 'Error'), 500);
            }

            // Get 1000 devices
            $records = Notification::whereRaw('currency_id = ? AND notify_type = ? AND is_send = ?', array($currency->id, $type, false))
                ->take(EXR_LIMIT_DEVICES)
                ->get();

            if (!count($records)) {
                // Update is_send for currency when send all devices.
                $currency->is_send = true;
                $currency->save();

                // Clear if crawl end devices.
                Notification::whereRaw('currency_id = ? AND notify_type = ? AND is_send = ? AND DATE(updated_at) != CURDATE()', array($currency->id, $type, true))
                    ->update(array('is_send', false));
            }

            // Convert devices registations ids to array.
            $deviceIds = $records->lists('device_id');

            $response = '';
            if (count($deviceIds) <= EXR_LIMIT_DEVICES && !empty($message)) {
                // Send to notification to it
                $response = Notification::sendNtfsToDevices($message, $deviceIds);
            }
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

        if (count($records)) {
            // Get currency type
            $currencyIds = [];
            $goldIds = [];

            foreach ($records as $item) {
                if ($item->code == 'GOLD') {
                    $goldIds[] = $item->id;
                } else {
                    $currencyIds[] = $item->id;
                }
            }

            var_dump(Currency::getCurrenciesDetail($goldIds, 'GOLD'));
            var_dump(Currency::getCurrenciesDetail($currencyIds, 'CURRENCY'));
            die();
        }
    }
}
