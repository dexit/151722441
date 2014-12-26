<?php namespace DLNLab\Classified\Models;

use Model;

/**
 * AdRead Model
 */
class AdRead extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_classified_ad_reads';

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

	private static function get_user_read($user, $count) {
		$result = new \stdClass;
		$result->user_id = $user->id;
		$result->email   = $user->email;
		$result->count   = $count;
		return $result;
	}
	
	public static function add_read($ad_id, $user) {
		if ( empty($ad_id) || empty($user) )
			return;
		// Get read entry exists in db
		$entry   = self::find($ad_id);
		$result  = null;
		$user_id = $user->id;
		if ($entry) {
			// For update
			$log   = json_decode($entry->log);
			$count = $entry->count;
			if (! empty($log->$user_id)) {
				$obj_user      = $log->$user_id;
				$new_user      = self::get_user_read($user, $obj_user->count + 1);
				$log->$user_id = $new_user;
			} else {
				$new_user      = self::get_user_read($user, 1);
				$log->$user_id = $new_user;
			}
			
			$entry->log   = json_encode($log);
			$entry->count = $count+1;
			$result = $entry->save();
		} else {
			// Insert new
			$log           = array();
			$log->$user_id = self::get_user_read($user, 1);
			
			$insert = new self;
			$insert->ad_id = $ad_id;
			$insert->count = 1;
			$insert->log   = json_encode($log);
			$result = $insert->save();
		}
		
		return $result;
	}
}