<?php namespace DLNLab\AloExrates\Classes;


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
     * Api function for crawl exrates.
     *
     * @return ResponseWWWWW
     */
    public function getExrates()
    {
        $records = Currency::where('crawl', '=', false)->take(5)->get();
        if (! count($records)) {
            Currency::where('crawl', '=', true)->update(array('crawl' => false));
            $records = Currency::where('crawl', '=', false)->take(5)->get();
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

}
