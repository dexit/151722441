<?php namespace DLNLab\Features\Models;

use Model;
use RainLab\User\Models\User;
use Backend\Models\User as BackendUser;

/**
 * Report Model
 */
class Report extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_reports';

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

	public function getStatusOptions() {
		return array('Pending', 'Approved', 'Good');
    }
	
	public function getStatusAttribute() {
		$options = $this->getStatusOptions();
		return isset($this->attributes['status']) ? $options[$this->attributes['status']] : $options[0];
	}
	
	public function getUserAttribute() {
		$user_name = '';
		if (isset($this->attribute['user_id'])) {
			$user = User::find($this->attribute['user_id']);
			$user_name = $user->name;
		}
		return $user_name;
	}
	
	public function canEdit(BackendUser $user)
    {
        return ($this->user_id == $user->id) || $user->hasAnyAccess(['rainlab.blog.access_other_posts']);
    }
}