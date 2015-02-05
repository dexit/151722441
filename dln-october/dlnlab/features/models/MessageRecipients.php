<?php namespace DLNLab\Features\Models;

use Auth;
use DB;
use Cache;
use Model;

/**
 * message_recipients Model
 */
class MessageRecipients extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_message_recipients';

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
	
	public static function getInboxCount($user_id = 0) {
		if ( empty( $user_id ) ) {
			$user_id = Auth::getUser()->id;
		}
		
		if (Cache::has('messages_unread_count_' . $user_id)) {
			$unread_count = Cache::get('messages_unread_count_' . $user_id);
		} else {
			$unread_count = self::where('user_id', '=', $user_id)->sum('unread_count');
			Cache::add('messages_unread_count_' . $user_id, $unread_count, 60);
		}
		
		return $unread_count;
	}
	
	public static function addSender($thread_id = 0, $sender_id = 0) {
		if (empty($thread_id) || empty($sender_id))
			return null;
		
		$record = new self;
		$record->user_id      = $sender_id;
		$record->unread_count = 0;
		$record->thread_id    = $thread_id;
		$record->is_sender    = true;
		$result = $record->save();
		
		return $result;
	}
	
	public static function addReceiver($thread_id = 0, $receiver_id = 0) {
		if (empty($thread_id) || empty($receiver_id))
			return null;
		
		$record = new self;
		$record->user_id      = $receiver_id;
		$record->unread_count = 1;
		$record->thread_id    = $thread_id;
		$record->is_sender    = false;
		$result = $record->save();
		
		Cache::forget('messages_unread_count_' . $receiver_id);
		
		return $result;
	}
	
	public static function getRecipients($thread_id = 0) {
		if (! $thread_id) {
			return null;
		}

		$recipients = array();
		$results    = self::whereRaw('thread_id = ? AND is_deleted = 0', array($thread_id));
		foreach ($results as $recipient)
			$recipients[$recipient->user_id] = $recipient;
		
		return $recipients;
	}
}