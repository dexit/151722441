<?php namespace DLNLab\Classified\Models;

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
     * country, state, ad_tag, ad_kind, ad_amenities
     */
	public function getTypeOptions() {
		return array(
			'ad_kind'      => 'Kind',
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
			'tags' => '',
			'country_tag' => '',
			'state_tag'   => '',
		);
		$merge = array_merge($default, $data);
        $merge = \DLNLab\Classified\Classes\HelperClassified::trim_value($merge);
        extract($merge);
		
        $tag_ids = array();
        
		// Find country tag
        $id = self::add_location_tag($country_tag, 'country');
        if ($id) {
            $tag_ids[] = $id;
        }
        
        // Find state tag
		$id = self::add_location_tag($state_tag, 'state');
        if ($id) {
            $tag_ids[] = $id;
        }
        
        $tags = explode(',', $tags);
        if ($tags) {
            foreach ($tags as $tag) {
                $id = self::add_location_tag($tag, 'ad_tag');
                if ($id) {
                    $tag_ids[] = $id;
                }
            }
        }
        
        return $tag_ids;
    }
    
    private static function add_location_tag($location_tag, $type = 'country') {
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