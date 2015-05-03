<?php namespace DLNLab\AloExrates\Models;

use Model;

/**
 * Devices Model
 */
class Devices extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_aloexrates_devices';

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
     * Static function for add new device id.
     *
     * @param string $device_id
     * @return Devices
     */
    public static function addDevice($device_id = '')
    {
        if (empty($device_id)) {
            return false;
        }

        // Check device_id exists in db
        $record = self::where('device_id', '=', $device_id)->first();
        if (empty($record)) {
            $record = new self;
            $record->device_id = $device_id;
            $record->save();
        }

        return $record;
    }
}