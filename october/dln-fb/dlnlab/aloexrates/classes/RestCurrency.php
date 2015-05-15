<?php namespace DLNLab\AloExrates\Classes;

use Illuminate\Routing\Controller as BaseController;
use DLNLab\AloExrates\Models\Currency;
use DLNLab\ALoExrates\Helpers\EXRHelper;
use Response;
use Validator;

/**
 * Restful for Currency api.
 *
 * @author dinhln
 * @since 02/05/2015
 */
class RestCurrency extends BaseController
{

    /**
     * Api function for get currencies listing json.
     * 
     * @return Response
     */
    public function getListCurrencies()
    {
        $data = get();
        
        // Validator get params.
        $valids = Validator::make($data, [
            'types' => 'required'
        ], EXRHelper::getMessage());
        
        // Response error message if not valids
        if ($valids->fails())
        {
            return Response::json(array('status' => 'error', 'data' => $valids->messages()));
        }
        
        extract($data);

        $types = explode(',', $types);
        
        /*$page  = intval($page);
        $limit = EXR_PAGINATE;
        $skip  = $page * $limit;*/
        
        // Get list currency ids
        $records = Currency::where('status', true)
            ->whereRaw('status = ?', array(true))
            ->whereIn('type', $types)
            ->orderBy('name', 'DESC')
            ->get(array('id', 'code', 'type', 'name', 'flag', 'created_at', 'updated_at'));
        
        return Response::json(array('status' => 'success', 'data' => $records));
    }
    
    /**
     * Api function for get currencies listing detail json.
     * 
     * @return Response
     */
    public function getListCurrenciesDetail()
    {
        $data = get();
        
        // Validator get params.
        $valids = Validator::make($data, [
            //'type' => 'required_if,type,CURRENCY,GOLD,CURRENCY|BANK',
            'currency_ids' => 'required',
            'week' => 'numeric|min:1|max:4'
        ], EXRHelper::getMessage());
        
        // Response error message if not valids
        if ($valids->fails())
        {
            return Response::json(array('status' => 'error', 'data' => $valids->messages()));
        }
        
        extract($data);

        $currency_ids = explode(',', $currency_ids);

        // Valids currency ids array
        $newCurrencyIds = array();
        foreach ($currency_ids as $id) 
        {
            $id = intval($id);
            if (! in_array($id, $newCurrencyIds))
            {
                $newCurrencyIds[] = $id;        
            }
        }
        
        // Get currencies details.
        $newRecords = Currency::getCurrenciesDetails($newCurrencyIds);
        
        return Response::json(array('status' => 'success', 'data' => $newRecords));
    }

    /**
     * Api function for get currency and listing by 7 days data.
     * 
     * @param number $currencyId
     * @return boolean|Response
     */
    public function getCurrenciesById($currencyId = 0)
    {
        // Validator input params.
        $valids = Validator::make([
            'currency_id' => $currencyId
        ], [
            'currency_id' => 'required|numeric|min:1'
        ], EXRHelper::getMessage());
        
        // Check fails.
        if ($valids->fails())
        {
            return Reponse::json(array('status' => 'error', 'data' => $valids->messages()), 500);
        }
        
        $cacheId = 'currency_detail_' . $currencyId;
        if (! Cache::has($cacheId))
        {
            $records = Currency::whereRaw('currency_id = ? AND created_at >= NOW() - INTERVAL ? WEEK', array($currencyId, DLN_LIMIT_WEEK))
                ->orderBy('updated_at', 'DESC')
                ->get();

            Cache::put($cacheId, json_encode($records->toArray()));
        }
        else 
        {
            $records = json_encode(Cache::get($cacheId, null));
        }
        
        return Response::json(array('status' => 'success', 'data' => $records));
    }
    
}
