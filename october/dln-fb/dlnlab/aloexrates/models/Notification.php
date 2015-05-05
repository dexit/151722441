<?php namespace DLNLab\AloExrates\Models;

use Model;

/**
 * Notification Model
 */
class Notification extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_aloexrates_notifications';

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

    /**
     * Static function for add new notification conditions.
     * 
     * @param object $data
     * @return \DLNLab\AloExrates\Models\Notification|boolean
     */
    public static function updateConditions($data = array())
    {
        if (empty($data['type']) && empty($data['sender_id']))
        {
            return false;
        }
        
        // Check exists sender_id in db.
        $record = self::whereRaw('sender_id = ? AND type = ?', array($data['sender_id'], $data['type']))->first();
        if ($record)
        {
            if (isset($data['is_min']) && $data['is_min'] != $record->is_min)
            {
                $record->is_min = $data['is_min'];
            }
            if (isset($data['is_max']) && $data['is_max'] != $record->is_max)
            {
                $record->is_max = $data['is_max'];
            }
        } else {
            $record = new self;
            $record->type = $data['type'];
            $record->sender_id = $data['sender_id'];
            
            if (isset($data['is_min']) && $data['is_min'] != $record->is_min)
            {
                $record->is_min = $data['is_min'];
            }
            if (isset($data['is_max']) && $data['is_max'] != $record->is_max)
            {
                $record->is_max = $data['is_max'];
            }
        }
        $record->save();
        
        return $record;
    }
    
}