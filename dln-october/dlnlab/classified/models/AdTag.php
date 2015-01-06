<?php namespace DLNLab\Classified\Models;

use DB;
use Model;

/**
 * Ad_Tag Model
 */
class AdTag extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_ad_tags';

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

	public static function updateCount( $tag_id = 0 ) {
        if ( ! $tag_id )
            return false;
		
        $count = DB::table('dlnlab_classified_ad_tags_relate')->where('tag_id', '=', $tag_id)->count();
        $find  = self::find($tag_id);
        $find->count = $count;
        $find->save();
        return true;
    }
	
}