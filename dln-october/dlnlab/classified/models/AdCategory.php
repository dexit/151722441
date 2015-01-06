<?php namespace DLNLab\Classified\Models;

use Model;

/**
 * AdCategory Model
 */
class AdCategory extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_ad_categories';

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

    protected static $nameList = null;

    public static function updateCountCategory( $id ) {
        if ( ! $id )
            return false;
        $count = Ad::where('category_id', '=', (int) $id)->count();
        $find  = self::find($id);
        $find->count = $count;
        $find->save();
        return true;
    }

    public static function getNameList()
    {
        if ( self::$nameList )
            return self::$nameList;

        return self::$nameList = self::lists( 'name', 'id' );
    }
}