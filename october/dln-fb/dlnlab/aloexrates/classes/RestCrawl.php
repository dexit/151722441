<?php

namespace DLNLab\AloExrates\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\AloExrates\Models\Currency;
use DLNLab\AloExrates\Models\CurrencyDaily;
use DLNLab\AloExrates\Models\BankDaily;
use DLNLab\AloExrates\Models\GoldDaily;
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
                    $cities = Currency::getCurrenciesByCodes($codes);
        
                    // Get exchange rates over bank api.
                    foreach ($cities as $city) {
                        $item = $xpath->query('//city[@name="' . $city->code . '"]/item')->item(0);
                        $currencyId = $city->id;
                        $buy        = $item->getAttribute('buy');
                        $sell       = $item->getAttribute('sell');
        
                        GoldDaily::updateGoldsDaily($currencyId, $buy, $sell, $type);
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
        $records = Currency::where('crawl', '=', false)->take(10)->get();
        if (! count($records)) {
            Currency::where('crawl', '=', true)->update(array(
                'crawl' => false
            ));
            $records = Currency::where('crawl', '=', false)->take(10)->get();
        }
        
        // Crawl data
        foreach ($records as $record) {
            if (CurrencyDaily::updatePriceDaily($record->id, $record->code)) {
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
                    
                    $doc = new \DOMDocument();
                    @$doc->loadXML($content);
                    $xpath = new \DOMXpath($doc);
                    
                    $items = $xpath->query('//Exrate');
                    $codes = array();
                    foreach ($items as $item) {
                        $codes[] = $item->getAttribute('CurrencyCode');
                    }
                    
                    // Get currency by ids
                    $currencies = Currency::getCurrenciesByCodes($codes);
                    
                    // Get exchange rates over bank api.
                    foreach ($currencies as $currency) {
                        $item = $xpath->query('//Exrate[@CurrencyCode="' . $currency->code . '"]')->item(0);
                        $currencyId = $currency->id;
                        $buy = $item->getAttribute('Buy');
                        $transfer = $item->getAttribute('Transfer');
                        $sell = $item->getAttribute('Sell');
                        
                        BankDaily::updateExratesDaily($currencyId, $buy, $transfer, $sell, $type);
                    }
                    
                    break;
                    
            }
        }
        
        return Response::json(array(
            'status' => 'Success',
            'data' => $apies
        ), 200);
    }
}
