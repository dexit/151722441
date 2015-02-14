<?php namespace DLNLab\Classified\Components;

use Input;
use Cms\Classes\ComponentBase;
use DLNLab\Classified\Models\Ad;
use DLNLab\Classified\Classes\HelperCache;

class Modal extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Modal Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'type' => [
                'title'       => 'Type',
                'description' => 'Desc',
                'type'        => 'dropdown',
                'default'     => 'location'
            ]
        ];
    }
    
    public function getTypeOptions() {
        return array(
            'location'  => 'Location'
        );
    }
    
    public function onRun() {
        $asset_css    = array(); 
        $asset_script = array();
        $type = (Input::has('type')) ? Input::get('type') : '';
        
        switch($type) {
            case 'location':
                $asset_script[] = '~/plugins/dlnlab/classified/assets/js/helpers/helper-googlemap.js';
                $asset_script[] = '~/plugins/dlnlab/classified/assets/js/modals/location.js';
                break;
            case 'photo':
                $asset_script[] = 'assets/vendor/jquery-ui/jquery-ui.min.js';
                $asset_script[] = 'assets/vendor/jquery-fileupload/js/vendor/jquery.ui.widget.js';
                $asset_script[] = 'assets/vendor/jquery-fileupload/js/jquery.fileupload.js';
                $asset_script[] = '~/plugins/dlnlab/classified/assets/js/modals/photo.js';
                
                // Get photos of Ad
                $ad_id = Input::has('ad_id') ? Input::get('ad_id') : '';
                $records = null;
                if ($ad_id) {
                    $ad = Ad::find($ad_id);
                    $records = $ad->ad_images;
                }
                $this->page['photos'] = $records;
                
                break;
            case 'amenity':
                $asset_script[] = '~/plugins/dlnlab/classified/assets/js/modals/amenity.js';
                
                $arr_selected = Input::has('values') ? explode(',', Input::get('values')) : '';
                $this->page['arr_selected'] = $arr_selected;
                $this->page['amenities'] = HelperCache::getAdAmenities();
                break;
        }
        
        $this->page['type']         = $type;
        $this->page['asset_css']    = $asset_css;
        $this->page['asset_script'] = $asset_script;
    }

}