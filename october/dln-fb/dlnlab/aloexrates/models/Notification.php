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