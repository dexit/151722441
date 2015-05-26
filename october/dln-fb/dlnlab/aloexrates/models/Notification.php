<?php namespace DLNLab\AloExrates\Models;

use Model;
use DLNLab\ALoExrates\Helpers\EXRHelper;

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
        if (empty($data['type']) || empty($data['reg_id']) || empty($data['currency_id']))
        {
            return false;
        }

        // Check limit notification number
        $record = self::whereRaw('reg_id = ? AND type = ?', array($data['reg_id'], $data['type']))->count();
        if ($record && $record >= EXR_LIMIT_NTFS)
        {
            return false;
        }
        
        // Check exists reg_id in db.
        $record = self::whereRaw('reg_id = ? AND type = ? AND currency_id = ?', array($data['reg_id'], $data['type'], $data['currency_id']))->first();
        if ($record)
        {
            if ($record->is_min == $data['is_min'] && $record->is_max == $data['is_max'])
            {
                return false;
            }

            $record->is_min = $data['is_min'];
            $record->is_max = $data['is_max'];
        } else {
            $record = new self;
            $record->type        = $data['type'];
            $record->reg_id      = $data['reg_id'];
            $record->currency_id = $data['currency_id'];
            $record->is_min      = $data['is_min'];
            $record->is_max      = $data['is_max'];
        }
        $record->save();
        
        return $record;
    }
    
    /**
     * Static function for send message to devices.
     * 
     * @param string $message
     * @param unknown $deviceIds
     * @return boolean|unknown
     */
    public static function sendNtfsToDevices($message = '', $deviceIds = array())
    {
        if (! $message || ! $deviceIds)
        {
            return false;
        }

        // Get registration ids
        $records = Devices::whereIn('id', $deviceIds)->get();
        $regIds = $records->lists('gcm_reg_id');

        if (! count($regIds)) {
            return false;
        }

        $registration_ids = implode(',', $regIds);
        $fields = array(
            'registration_ids' => $regIds,
            'data' => array(
                'message' => $message
            )
        );
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, GOOGLE_GCM_URL);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        //$result = EXRHelper::curl(GOOGLE_GCM_URL, json_encode($fields), $headers);
        
        return $result;
    }
}