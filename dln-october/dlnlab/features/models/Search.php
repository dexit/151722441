<?php namespace DLNLab\Features\Models;

use Model;
use Validator;
use DLNLab\Classified\Models\Ad;

/**
 * Search Model
 */
class Search extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_searches';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
	
	public $allow_field = array('price_min', 'price_max', 'area_min', 'area_max', 'user_id', 'state_id', 'country_id', 'category_id', 'sale_type_id');
	
	public function add($title = '', $search_query = '') {
		if (empty($search_query))
			return false;
		
		if (! Auth::check())
			return false;
		
		$user_id = Auth::getUser()->id;
		
		if ($query = $this->valid_query($search_query)) {
			// Check query exists in DB
			$record = self::where('query', '=', $query)->first();
			if (empty($record)) {
				$record = new self;
				$record->query = $query;
				$record->save();
			}
			
			// Check current user used query
			$search_id = $record->id;
			$record    = SearchUser::whereRaw('user_id = ? AND search_id = ?', array($user_id, $search_id))->first();
			if (empty($record)) {
				$record            = new SearchUser;
				$record->title     = $title;
				$record->user_id   = $user_id;
				$record->search_id = $search_id;
				$record->save();
			}
		} else {
			return false;
		}
	}

	public function query($search_id = '', $page) {
		if (! $searches) 
			return null;
		
		$record = self::find($search_id);
		
		if (! $record)
			return null;
		
		$arr_query = json_decode($record->query);
		
		// Build query ads
		$ad_query  = 'null';
		$ad_params = array();
		foreach ($arr_query as $param => $value) {
			switch ($param) {
				case 'price_min':
					$ad_query    .= 'price >= ?';
					$ad_params[] = $value;
					break;
				
				case 'price_max':
					$ad_query    .= 'price <= ?';
					$ad_params[] = $value;
					break;
				
				case 'area_min':
					$ad_query    .= 'area >= ?';
					$ad_params[] = $value;
					break;
				
				case 'area_max':
					$ad_query    .= 'area <= ?';
					$ad_params[] = $value;
					break;
				
				case 'user_id':
					$ad_query    .= 'user_id = ?';
					$ad_params[] = $value;
					break;
				
				case 'state_id':
					$ad_query    .= 'state_id = ?';
					$ad_params[] = $value;
					break;
				
				case 'country_id':
					$ad_query    .= 'country_id = ?';
					$ad_params[] = $value;
					break;
				
				case 'category_id':
					$ad_query    .= 'category_id = ?';
					$ad_params[] = $value;
					break;
				
				case 'sale_type_id':
					$ad_query    .= 'sale_type_id = ?';
					$ad_params[] = $value;
					break;
			}
		}
		
		$results = Ad::whereRaw($ad_query, $ad_params)->take(10)->get();
		
		return $results;
	}
	
	public function crawl_search() {
		// Get 100 search from DB
		$searches = self::orderBy('crawl', 'asc')->take(100)->get();
		if ($searches->count()) {
			foreach ($searches as $search) {
				$search_id = $search->id;
				
			}
		}
	}
	
	private function valid_query($search_query = '') {
		if (empty($search_query))
			return '';
		
		parse_str($search_query, $arr_search);
		
		$allow_field = asort($this->allow_field);
		
		$arr_data = array();
		foreach ( $allow_field as $item ) {
			foreach ( $arr_search as $key => $value ) {
				if ($item == $key) {
					$arr_data[$item] = $value;
				}
			}
		}
		
		$rules = [
			'price_min' => 'numeric',
			'price_max' => 'numeric',
			'area_min'  => 'numeric',
			'area_max'  => 'numeric',
			'user_id'   => 'numeric',
			'state_id'  => 'numeric',
			'region_id' => 'numeric',
			'location_type_id' => 'numeric',
			'sale_type_id'     => 'numeric',
		];
		
		$validation = Validator::make($arr_data, $rules);
		if ($validation->fails()) {
			throw new \Exception($validation->messages()->first(), 400, null);
			return false;
		}
		
		return json_encode($arr_data);
	}

}