<?php namespace DLNLab\Classified\Models;

use DB;
use Str;
use Model;

/**
 * Tag Model
 */
class Tag extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_tags';

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
    public $belongsToMany = [
		'ads' => ['DLNLab\Classified\Ad', 'table' => 'dlnlab_classified_ads_tags', 'order' => 'published_at desc', 'scope' => 'isPublished']
	];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    /*
     * country, state, ad_tag, ad_amenities
     */
	public function getTypeOptions() {
		return array(
			'ad_amenities' => 'Amenities',
		);
	}
	
	public static function updateCount( $tag_id = 0 ) {
        if ( ! $tag_id )
            return false;
		
        $count = DB::table('dlnlab_classified_ads_tags')->where('tag_id', '=', $tag_id)->count();
        $find  = self::find($tag_id);
        $find->count = $count;
        $find->save();
        return true;
    }
	
	public static function save_tag($data = array()) {
		$default = array(
            'ad_id'     => '0',
			'tag_ids'   => '',
			'city_tag'  => '',
			'state_tag' => '',
		);
		$merge = array_merge($default, $data);
        $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
        extract($merge);
		
        if (! $ad_id)
            return false;
        
        $arr_tag_ids = array();
        
		// Find city tag
        if ($city_tag) {
            $id = self::add_location_tag($city_tag, 'city');
            if ($id) {
                $arr_tag_ids[] = array( 'ad_id' => $ad_id, 'tag_id' => $id );
            }
        }
        
        
        // Find state tag
        if ($state_tag) {
            $id = self::add_location_tag($state_tag, 'state');
            if ($id) {
                $arr_tag_ids[] = array( 'ad_id' => $ad_id, 'tag_id' => $id );
            }
        }
        
        $tag_ids = explode(',', $tag_ids);
        if ($tag_ids) {
            $cache_ids = array();
            foreach ($tag_ids as $id) {
                if (! in_array($id, $cache_ids)) {
                    $cache_ids[]   = $id;
                    $arr_tag_ids[] = array( 'ad_id' => $ad_id, 'tag_id' => $id );
                }
            }
        }
        
        if (count($arr_tag_ids)) {
            $records = DB::table('dlnlab_classified_ads_tags')->where('ad_id', '=', $ad_id)->delete();
            DB::table('dlnlab_classified_ads_tags')->insert($arr_tag_ids);
        }
        return true;
    }
    
    private static function add_location_tag($location_tag, $type = 'city') {
        $id           = null;
        $location_tag = trim($location_tag);
		if ($location_tag) {
            $slug = Str::slug($location_tag, '-');
			$tag  = self::whereRaw('slug = ? AND type = ?', array($slug, $type))->first();
            if (! $tag) {
                $tag = new self;
                $tag->name   = $location_tag;
                $tag->tag    = $slug;
                $tag->status = 0;
                $tag->count  = 1;
            } else {
                // For same slug exists
                if ($tag->name == $location_tag) {
                    // If same name
                    $tag->count  = $tag->count + 1;
                } else {
                    $id = $tag->id;
                    // Add new tag with slug other
                    $tag = new self;
                    $tag->name   = $location_tag;
                    $tag->tag    = $slug . '-' . $id;
                    $tag->status = 0;
                    $tag->count  = 1;
                }
            }
            $tag->save();
            
            $id = $tag->id;
		}
        
        return $id;
    }
	
    public static function getTagByType($type = '') {
        if (! $type)
            return null;
        
        $records = self::whereRaw('type = ? AND status = ?', array($type, 1))->orderBy('slug', 'ASC')->get(array('id', 'name', 'slug', 'icon'));
        if (count($records)) {
            return $records;
        }
        return null;
    }
    
}