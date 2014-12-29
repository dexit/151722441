<?php namespace DLNLab\Features\Models;

use DB;
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
	
	public static function addThread($sender_id, $receiver_id, $message) {
		// Get max thread_id
		$thread_id = self::max('thread_id') + 1;
		if (empty($thread_id) || empty($sender_id) || empty($receiver_id) || empty($message))
			return;
		
		DB::beginTransaction();
		try {
			// Insert new message thread
			$insert = new self;
			$insert->thread_id = $thread_id;
			$insert->sender_id = $sender_id;
			$insert->message   = $message;
			$result = $insert->save();
			if (!$result) {
				throw  new \Exception('Can\'t sent message');				
			}
		} catch (Exception $ex) {
			DB::rollback();
			throw $ex;
		}
		
		try {
			// Insert sender to recipient table
			if (! MessageRecipients::addSender($thread_id, $sender_id) ) {
				throw  new \Exception('Can\'t sent message from user');
			}
		} catch (Exception $ex) {
			DB::rollback();
			throw $ex;
		}

		try {
			// Insert receiver to
			if (! MessageRecipients::addReceiver($thread_id, $receiver_id) ) {
				throw  new \Exception('Can\'t sent message to receiver');
			}
		} catch (Exception $ex) {
			DB::rollback();
			throw $ex;
		}
		
		DB::commit();
	}
	
	public static function markAsRead($thread_id = 0) {
		if (empty($thread_id))
			return null;
		
		if (!Auth::check())
			return null;
		
		$user_id    = Auth::getUser()->id;
		$affectRows = MessageRecipients::whereRaw('user_id = ? AND thread_id = ?', array($user_id, $thread_id))->update(array('unread_count' => 0));
		
		Cache::forget('messages_unread_count');
		
		return $affectRows;
	}
	
	public static function getTotalThreadsForUser($user_id, $box = 'inbox', $type = 'all') {
		if ( empty($user_id) || empty($box) || empty($type) )
			return null;
		
		$exclude_sender = '';
		if ( $box != 'sentbox' )
			$exclude_sender = ' AND sender_only != 1';

		if ( $type == 'unread' )
			$type_sql = " AND unread_count != 0 ";
		else if ( $type == 'read' )
			$type_sql = " AND unread_count = 0 ";

		return MessageRecipients::whereRaw('user_id = ? ? ?', array($user_id, $exclude_sender, $type_sql))->count('thread_id');
	}
	
	public static function checkAccess($thread_id, $user_id = 0) {
		if ( empty($user_id) || empty($thread_id) )
			return null;

		if ( empty( $user_id ) )
			$user_id = Auth::getUser()->id;
		
		return MessageRecipients::whereRaw('thread_id = ? AND is_deleted = 0 AND user_id = ?', array($thread_id, $user_id))->count();
	}
	
	public function getRecipients() {
		if (! $this->attributes['thread_id']) {
			return null;
		}

		$recipients = array();
		$results    = MessageRecipients::where('thread_id', '=', $this->attributes['thread_id']);
		foreach ($results as $recipient)
			$recipients[$recipient->user_id] = $recipient;
		
		return $recipients;
	}
	
	public static function userIsSender($thread_id) {
		if (empty($thread_id))
			return null;

		$messages = self::where('thread_id', '=', $thread_id);
		
		if ( ! $messages ) {
			return false;
		}
		
		$return = false;
		foreach ($messages as $message) {
			if ($message->sender_id == Auth::getUser()->id) {
				$return = true;
				break;
			}
		}

		return $return;
	}
}