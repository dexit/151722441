<?php

namespace DLNLab\Classified\Models;

use App;
use Auth;
use DB;
use Response;
use Str;
use October\Rain\Database\Model;
use October\Rain\Auth\Models\User as UserBase;
use RainLab\User\Models\Country;
use RainLab\User\Models\State;

use DLNLab\Classified\Classes\HelperClassified;
use DLNLab\Classified\Classes\HelperCache;

/**
 * Ad Model
 */
class Ad extends Model {

    use \October\Rain\Database\Traits\Validation;
    
	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'dlnlab_classified_ads';

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
		'desc',
        'full_text',
		'price',
		'expiration',
		'address',
		'country',
		'state',
		'lat',
		'lng'
	];
    
	public $rules = [
		'name'       => 'required',
		'slug'        => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i'],
		'price'       => 'required|numeric',
        'category_id' => 'required|numeric',
        'id'          => 'numeric',
        'user_id'     => 'numeric',
        //'lat'         => 'regex:/^[+-]?\d+\.\d+, ?[+-]?\d+\.\d+$/',
        //'lng'         => 'regex:/^[+-]?\d+\.\d+, ?[+-]?\d+\.\d+$/',
	];
    public $customMessages = array(
        'required'  => 'Yêu cầu nhập :attribute.',
        'array'     => ':attribute phải đúng dạng array.',
        'between'   => ':attribute phải nằm trong khoảng :min - :max số.',
        'numeric'   => ':attribute phải dùng dạng số.',
        'alpha_num' => ':attribute không được có ký tự đặc biệt.',
        'size'      => ':attribute bị giới hạn :size ký tự.',
        'min'       => ':attribute phải lớn hơn :min.',
        'max'       => ':attribute phải nhỏ hơn :max.',
        'regex'     => ':attribute không hợp lệ.',
    );
    
    public $attributeNames = [
        'name'        => 'Tiêu đề',
        'slug'        => 'Slug',
        'price'       => 'Giá',
        'category_id' => 'Danh mục',
        'address'     => 'Địa chỉ',
        'desc'        => 'Mô tả',
        'lat'         => 'Vĩ độ',
        'lng'         => 'Kinh độ',
        'user_id'     => 'Người dùng'
    ];
    public $throwOnValidation = false;

	/**
	 * @var array Relations
	 */
	public $hasOne = [];
	public $hasMany = [];
	public $belongsTo = [
		'category' => ['DLNLab\Classified\Models\AdCategory'],
		'country' => ['RainLab\User\Models\Country'],
		'state' => ['RainLab\User\Models\State'],
        'user' => ['RainLab\User\Models\User', 'foreign_key' => 'user_id']
	];
	public $belongsToMany = [
		'tags' => ['DLNLab\Classified\Models\Tag', 'table' => 'dlnlab_classified_ads_tags', 'order' => 'name']
	];
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

    public function category()
    {
        return $this->belongsTo('DLNLab\Classified\Models\AdCategory');
    }
    
	public function getStatusOptions() {
		return array('Pending', 'Published');
	}

	public function getCategoryOptions() {
		return AdCategory::getNameList();
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

    public function beforeSave() {
        // Check user id co hop le hay khong
        if ($this->getAttribute('user_id') && Auth::check()) {
            $user_id = $this->getAttribute('user_id');
            if ($user_id != Auth::getUser()->id) {
                throw new Exception('Tin này không phải của người dùng hiện tại!', 500);
            }
        }
        
        // Format lai price
        $price = $this->getAttribute('price');
        $price = str_replace(',', '', $price);
        $price = doubleval($price);
        $this->setAttribute('price', $price);
        
        // Format user_id
        $user_id = $this->getAttribute('user_id');
        if (empty($user_id)) {
            $this->setAttribute('user_id', Auth::getUser()->id);
        }
        
        // Tao slug full_text va snippet content cho fulltext search
        $desc         = Str::words($this->getAttribute('desc'));
        $slug         = str_replace('-', ' ', $this->getAttribute('slug'));
        $slug_address = HelperClassified::slug_utf8($this->getAttribute('address'));
        $slug_address = str_replace('-', ' ', $slug_address);
        $arr_text   = array();
        $arr_text[] = $this->getAttribute('name');
        $arr_text[] = $slug;
        $arr_text[] = $desc;
        $arr_text[] = $this->getAttribute('address');
        $arr_text[] = $slug_address;
        
        $text = implode(' ', $arr_text);
        $this->setAttribute('full_text', $text);
        
        // Cap nhat publish time
        if ($this->getAttribute('status') == 1) {
            $this->setAttribute('published_at', time());
        }
        
        // Cap nhat trang thai link share count sns
        if (! empty($this->attributes['id'])) {
            AdShareCount::where('ad_id', '=', $this->attributes['id'])->update(array('status' => $this->getAttribute('status')));
        }
    }
    
    public function afterCreate() {
        // Insert ad link for crawl share sns count information
        $ad_id = $this->attributes['id'];
        if (empty($ad_id)) {
            return false;
        }
        
        $link = self::get_ad_link($ad_id);
        
        $record = AdShareCount::where('ad_id', '=', $ad_id)->first();
        if (! $record) {
            $record = new AdShareCount;
            $record->ad_id = $ad_id;
        }
        $record->save();
    }

    public static function get_ad_link($ad_id = 0) {
        if (! $ad_id)
            return false;
        
        return OCT_ROOT . $ad_id;
    }

    public static function gen_auto_ad_name($data) {
        $default = array(
            'tag_ids' => '',
            'category_id' => '',
            'price' => ''
        );
        $merge = array_merge($default, $data);
        $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
        extract($merge);
        
        if (! $tag_ids)
            return false;
        
        $kind = $amenity = '';
        foreach ($tag_ids as $id) {
           $tag = HelperCache::findAdTagById($id);
           if ($tag) {
               switch ($tag->type) {
                   case 'ad_kind':
                       $kind = $tag->name;
                       break;
                   case 'ad_amenities':
                       $amenity = $tag->name;
                       break;
               }
           }
        }

        $category = HelperCache::findAdCategoryById($category_id);
        $ad_name = ucfirst($kind);
        $ad_name .= ' ' . mb_strtolower($category->name);
        $ad_name .= ' giá ' . mb_strtolower($price) . ' đồng';
        
        return $ad_name;
    }
    
}
