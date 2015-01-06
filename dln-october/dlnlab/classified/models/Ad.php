<?php

namespace DLNLab\Classified\Models;

use App;
use Model;
use October\Rain\Auth\Models\User as UserBase;
use RainLab\User\Models\Country;
use RainLab\User\Models\State;

/**
 * Ad Model
 */
class Ad extends Model {

	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'dlnlab_classified_ad';

	/**
	 * @var array Guarded fields
	 */
	protected $guarded = ['*'];

	/**
	 * @var array Fillable fields
	 */
	protected $fillable = [
		'name',
		'slug',
		'description',
		'price',
		'expiration',
		'address',
		'country',
		'state',
		'latitude',
		'longtitude'
	];
	
	public $rules = [
        'title'       => 'required',
        'slug'        => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i'],
        'description' => 'required',
		'price'       => 'required|numeric',
		'latitude'    => 'required',
		'longtitude'  => 'required'
    ];

	/**
	 * @var array Relations
	 */
	public $hasOne = [];
	public $hasMany = [];
	public $belongsTo = [
		'category' => ['DLNLab\Classified\Models\AdCategory'],
		'country' => ['RainLab\User\Models\Country'],
		'state' => ['RainLab\User\Models\State'],
	];
	public $belongsToMany = [];
	public $morphTo = [];
	public $morphOne = [];
	public $morphMany = [];
	public $attachOne = [];
	public $attachMany = [
		'ad_images' => ['System\Models\File']
	];
	public static $allowedSortingOptions = array(
		'name asc' => 'Name asc',
		'name desc' => 'Name desc',
		'slug asc' => 'Slug asc',
		'slug desc' => 'Slug desc',
		'created_at asc' => 'Created asc',
		'created_at desc' => 'Created desc',
		'updated_at asc' => 'Updated asc',
		'updated_at desc' => 'Updated desc',
		'published_at asc' => 'Published asc',
		'published_at desc' => 'Published desc',
	);
	protected $dates = ['published_at'];

	public function getStatusOptions() {
		return array('Pending', 'Published');
	}

	public function getCategoryOptions() {
		return AdCategory::getNameList();
	}

	public function getCountryOptions() {
		return Country::getNameList();
	}

	public function getStateOptions() {
		return State::getNameList($this->country_id);
	}

	public function scopeListFrontEnd($query, $options) {
		extract(array_merge([
			'page' => 1,
			'perPage' => 30,
			'sort' => 'created_at',
			'categories' => null,
			'search' => '',
			'published' => true
						], $options));

		$searchableFields = ['name', 'slug', 'description', 'address'];

		App::make('paginator')->setCurrentPage($page);

		if ($published)
			$query->isPublished();

		// Sorting
		if (!is_array($sort))
			$sort = [$sort];
		foreach ($sort as $_sort) {
			if (in_array($_sort, array_keys(self::$allowedSortingOptions))) {
				$parts = explode(' ', $_sort);
				if (count($parts) < 2)
					array_push($parts, 'desc');
				list($sortField, $sortDirection) = $parts;

				$query->orderBy($sortField, $sortDirection);
			}
		}

		// Search
		$search = trim($search);
		if (strlen($search)) {
			$query->searchWhere($search, $searchableFields);
		}

		// Categories
		if ($categories !== null) {
			if (!is_array($categories))
				$categories = [$categories];
			$query->whereHas('categories', function($q) use ($categories) {
				$q->whereIn('id', $categories);
			});
		}

		return $query->paginate($perPage);
	}

	public function scopeIsPublished($query) {
		return $query
				->whereNotNull('status')
				->where('status', '=', 1)
		;
	}

	public function setUrl($pageName, $controller) {
		$params = [
			'id' => $this->id,
			'slug' => $this->slug,
		];

		if (array_key_exists('categories', $this->getRelations())) {
			$params['category'] = $this->categories->count() ? $this->categories->first()->slug : null;
		}

		return $this->url = $controller->pageUrl($pageName, $params);
	}

}
