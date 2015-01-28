<?php namespace DLNLab\Classified\Models;

use Model;

/**
 * AdSharePage Model
 */
class AdSharePage extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_ad_share_pages';

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
    
    public static $gplus_page_id = array(
        '112236745001527485570'
    );
    public static $gplus_email = 'dinhln1989@gmail.com';
    public static $gplus_pwd   = 'dinhle287';
    

    public function getLikeAttribute() {
        $like = number_format((float) $this->attributes['like']);
        return $like;
    }
    
    public function getFBIDAttribute() {
        $fb_id = $this->attributes['fb_id'];
        return "<a href='https://www.facebook.com/{$fb_id}' target='_blank' onclick='javascript:void(0)'>https://www.facebook.com/{$fb_id}</a>";
    }
    
    public static function connect_gplus($autoposter) {
        if (! $autoposter)
            return false;
        
        $googleplus = $autoposter->getApi('googleplus', array(
            'email' => self::$gplus_email,
            'pass'  => self::$gplus_pwd
        ));
        
        return $googleplus;
    }
    
    public static function post_gplus_wall($googleplus, $page_id, $message) {
        $googleplus->begin($page_id);
        $googleplus->postToWall($message);
        $googleplus->end();
        if ($googleplus->isHaveErrors()) {
            var_dump($googleplus->getErrors());die();
        }
            
    }
}