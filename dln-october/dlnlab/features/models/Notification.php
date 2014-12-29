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
	
	public function add($user_id, $item_id, $secondary_item_id, $component_name, $component_action) {
		if (empty($user_id) || empty($item_id)) {
			return null;
		}
		try {
			$record = new static;
			$record->user_id           = $user_id;
			$record->item_id           = $item_id;
			$record->secondary_item_id = $secondary_item_id;
			$record->component_name    = $component_name;
			$record->component_action  = $component_action;
			$record->is_new            = true;
			$record->save();

			return $record;	
		} catch (Exception $ex) {
			return null;
		}
	}
	
	public static function has_read($user, $ids) {
		$ids     = str_replace('.', '', $ids);
		$ids     = ltrim($ids, ',');
		$ids     = rtrim($ids, ',');
		$records = self::whereRaw("user_id = ? AND id IN ({$ids})", array($user->id))->update(array('read' => 1));
		return $records;
	}
}