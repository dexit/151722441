<?php namespace DLNLab\Features\Models;

use Model;

/**
 * message_threads Model
 */
class MessageThreads extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_message_threads';

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

	public function getDates() {
        return array('created_at');
    }

    public function setUpdatedAtAttribute($value) {
        return null;
    }
	
	public static function add_thread($sender_id, $receiver_id, $message) {
		// Get max thread_id
		$thread_id = self::max('thread_id') + 1;
		if (empty($thread_id) || empty($sender_id) || empty($receiver_id) || empty($message))
			return;
		
		// Insert sender to recipient table
		$record = new MessageRecipients;
		$record->user_id   = $sender_id;
		$record->thread_id = $thread_id;
		$record->is_sender = true;
		$record->save();
		
		// Insert receiver to 
		$record = new MessageRecipients;
		$record->user_id   = $receiver_id;
		$record->thread_id = $thread_id;
		$record->is_sender = false;
		$record->save();
		
		// Insert new message thread
		$insert = new self;
		$insert->thread_id = $thread_id;
		$insert->sender_id = $sender_id;
		$insert->message   = $message;
		$insert->save();
	}
}