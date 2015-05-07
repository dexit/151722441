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
        if (empty($data['type']) || empty($data['sender_id']) || empty($data['currency_id']))
        {
            return false;
        }

        // Check limit notification number
        $record = self::whereRaw('sender_id = ? AND type = ?', array($data['sender_id'], $data['type']))->count();
        if ($record && $record >= EXR_LIMIT_NTFS)
        {
            return false;
        }
        
        // Check exists sender_id in db.
        $record = self::whereRaw('sender_id = ? AND type = ? AND currency_id = ?', array($data['sender_id'], $data['type'], $data['currency_id']))->first();
        if ($record)
        {
            if ($record->is_min == $data['is_min'] && $record->is_max == $data['is_max'])
            {
                return false;
            }

            if ($data['is_min'] != $record->is_min)
            {
                $record->is_min = $data['is_min'];
            }

            if ($data['is_max'] != $record->is_max)
            {
                $record->is_max = $data['is_max'];
            }
        } else {
            $record = new self;
            $record->type        = $data['type'];
            $record->sender_id   = $data['sender_id'];
            $record->currency_id = $data['currency_id'];
            
            if ($data['is_min'] != $record->is_min)
            {
                $record->is_min = $data['is_min'];
            }

            if ($data['is_max'] != $record->is_max)
            {
                $record->is_max = $data['is_max'];
            }
        }
        $record->save();
        
        return $record;
    }
    
    /**
     * Static function for send message to devices.
     * 
     * @param string $message
     * @param unknown $regIds
     * @return boolean|unknown
     */
    public static function sendNtfsToDevices($message = '', $regIds = array())
    {
        if (! $message || ! $regIds)
        {
            return false;
        }
        
        $registration_ids = implode(',', $regIds);
        $fields = array(
            'registration_ids' => $registration_ids,
            'message' => $message
        );
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        
        $result = EXRHelper::curl(GOOGLE_GCM_URL, $fields, $headers);
        
        return $result;
    }
}