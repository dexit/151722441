<?php namespace DLNLab\Features\Models;

use Model;

/**
 * Notification Model
 */
class Notification extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_notifications';

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
    public $belongsTo = [
		'user' => ['RainLab\User\Models\User', 'foreignKey' => 'user_id']
	];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
	
	public function getReadOptions() {
		return array('Pending', 'Viewed');
	}
	
	public function getReadAttribute() {
		$options = $this->getStatusOptions();
		return $options[$this->attributes['read']];
	}
	
	public function getUserOptions() {
		$user = User::find($this->user_id);
		return array(
			$user->id => $user->name
		);
	}
	
	public function add($receiver, $type, $content) {
		$record = new static;
        $record->user_id = $receiver->id;
		$record->type    = $type;
		$record->content = $content;
		$record->read    = 0;
        $record->save();

        return $record;
	}
}