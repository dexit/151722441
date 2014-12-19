<?php namespace DLNLab\Features\Models;

use Model;

/**
 * Money Model
 */
class Money extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_features_money';

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
	
	public function getUserOptions() {
		$user = User::find($this->user_id);
		return array(
			$user->id => $user->name
		);
	}
	
	public function getTypeOptions() {
		return array('NULL', 'Recharge Money', 'Convert Gems', 'Deduction money');
	}
	
	public function getStatusOptions() {
		return array('Disable', 'Enable');
    }
	
	public function getStatusAttribute() {
		$options = $this->getStatusOptions();
		return isset($this->attributes['status']) ? $options[$this->attributes['status']] : $options[0];
	}
	
	public function getTypeAttribute() {
		$options = $this->getTypeOptions();
		return isset($this->attributes['type']) ? $options[$this->attributes['type']] : $options[0];
	}
	
}