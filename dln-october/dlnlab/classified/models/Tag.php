<?php namespace DLNLab\Classified\Models;

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

	public function getTypeOptions() {
		return array(
			'ad_type' => 'Ad'
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
	
}