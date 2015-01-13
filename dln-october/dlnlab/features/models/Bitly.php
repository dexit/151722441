<?php namespace DLNLab\Features\Models;

use Model;

/**
 * Bitly Model
 */
class BitLy extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_bitlies';

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
    
    public $timestamps = false;
    
    public static $host         = 'https://api-ssl.bitly.com/';
    public static $access_token = '9e016bcaeee8f29bae802366a3f2eaa32b4937fc';
    
    public function beforeCreate() {
        $link = $this->getAttribute('link');
        $md5  = $this->getAttribute('md5');
        
        if ($link && $md5) {
            $link = self::$host . 'v3/shorten?access_token=' . self::$access_token . '&longUrl=' . $link;
            $obj = file_get_contents($link);
            $obj = json_decode($obj);
            
            if (! empty($obj->status_code) && $obj->status_code == 200) {
                $hash = $obj->data->global_hash;
                $url  = $obj->data->url;
                
                if ($hash && $url) {
                    $this->setAttribute('hash', $hash);
                    $this->setAttribute('bit_link', $url);
                }
            }
        }
    }

}