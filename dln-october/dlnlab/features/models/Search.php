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
	
	public static function add($title = '', $search_query = '') {
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

	public static function query($search_id = '', $is_count = false) {
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
				
				case 'category_id':
					$ad_query    .= 'category_id = ?';
					$ad_params[] = $value;
					break;
				
				case 'ad_type_id':
					$ad_query    .= 'ad_type_id = ?';
					$ad_params[] = $value;
					break;
			}
		}
		
		if (! $is_count) {
			$results = Ad::whereRaw($ad_query, $ad_params)->paginate(10)->get();
		} else {
			$results = Ad::whereRaw($ad_query, $ad_params)->count();
		}
		
		return $results;
	}
	
	public static function crawl_search() {
		// Get 100 search from DB
		$searches = self::orderBy('crawl', 'asc')->take(100)->get();
		if ($searches->count()) {
			foreach ($searches as $search) {
				$search_id = $search->id;
				
				$count = self::query($search_id);
				if ($count) {
					$rows = SearchUser::whereRaw('search_id = ? AND is_readed = 1 AND is_deleted = 0', array($search_id))->get();
					if ($rows->count()) {
						// Update notification for user
						$arr_users = array();
						foreach ($rows as $row) {
							$arr_users[] = new Notification();
						}
						SearchUser::whereRaw('search_id = ? AND is_readed = 1 AND is_deleted = 0', array($search_id))
							->update(array('last_search_count' => $count, 'is_readed' => false));
					}
					
					
				}
				$search->crawl = $search->crawl + 1;
				$search->save();
			}
		}
	}
	
	private static function valid_query($search_query = '') {
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
			'location_type_id' => 'numeric',
			'ad_type_id'       => 'numeric',
		];
		
		$validation = Validator::make($arr_data, $rules);
		if ($validation->fails()) {
			throw new \Exception($validation->messages()->first(), 400, null);
			return false;
		}
		
		return json_encode($arr_data);
	}

}