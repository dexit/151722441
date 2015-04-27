<?php namespace DLNLab\SNSContacts\Models;

use Model;
use Validator;

/**
 * Location Model
 */
class Location extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_snscontacts_locations';

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
     * Function for get location by latitude longitude.
     * 
     * @param string $lat
     * @param string $lng
     * @param boolean $isDB
     * @return boolean|object
     */
    public static function addLocationByLatLng($data, $isDB = false) {
        if (! count($data)) {
            return false;
        }
        
        // Validator lat lng.
        $validator = Validator::make($data, [
            'lat' => 'required|regex:/^[+-]?\d+\.\d+, ?[+-]?\d+\.\d+$/',
            'lng' => 'required|regex:/^[+-]?\d+\.\d+, ?[+-]?\d+\.\d+$/'
        ]);
        
        if ($validator->fails()) {
            return false;
        }
        
        // Get geocoding json data.
        $url = sprintf(SNSC_GEO_API, [$data['lat'], $data['lng']]);
        $data = @file_get_contents($url);
        $jsondata = json_decode($data, true);
        
        // Get country code
        $country = self::getNameByType('country', $jsonData['results'][0]['address_components']);
        
        if ($country->short_name != 'VN') {
            return false;
        }
        
        // Get province
        $province = self::getNameByType('administrative_area_level_1', $jsonData['results'][0]['address_components']);
        
        // Get district
        $district = self::getNameByType('administrative_area_level_2', $jsonData['results'][0]['address_components']);
        
        // Get Ward
        $ward = self::geNameByType('sublocality_level_1', $jsonData['results'][0]['address_components']);
        
        // Insert to DB
        $loc_id = 0;
        if ($isDB) {
            $obj = new \stdClass();
            
            // Insert province
            $record = self::firstOrNew(array('name' => $province->long_name, 'type' => 'province'));
            $obj->province = $province->long_name;
            
            // Insert district
            $loc_id += $record->id * 100;
            $record = self::firstOrNew(array('name' => $district->long_name, 'parent_id' => $record->id, 'type' => 'district'));
            $obj->district = $district->long_name;
            
            // Insert ward
            $loc_id += $record->id * 10;
            $record = self::firstOrNew(array('name' => $ward->long_name, 'parent_id' => $record->id, 'type' => 'ward'));
            $loc_id += $record->id * 1;
            $obj->ward     = $ward->long_name;
            
            // Add location_id
            $obj->location_id = $loc_id;
            
            return $obj;
        } else {
            $obj = new \stdClass();
            $obj->province = $province->long_name;
            $obj->district = $district->long_name;
            $obj->ward     = $ward->long_name;
            
            return $obj;
        }
    }
    
    /**
     * Private function for get name object by type
     * 
     * @param string $type
     * @param unknown $array
     * @param string $short_name
     * @return boolean|string
     */
    private static function geNameByType($type = '', $array = array()) {
        if (! $type) {
            return false;
        }
        
        foreach($array as $value) {
            if (in_array($type, $value['types'])) {
                return $value;
            }
        }
    }
     
}