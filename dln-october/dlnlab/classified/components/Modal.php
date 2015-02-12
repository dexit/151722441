<?php namespace DLNLab\Classified\Components;

use Input;
use Cms\Classes\ComponentBase;

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
                $asset_script[] = 'assets/vendor/jquery-fileupload/js/vendor/jquery.ui.widget.js';
                $asset_script[] = 'assets/vendor/jquery-fileupload/js/jquery.fileupload.js';
                $asset_script[] = '~/plugins/dlnlab/classified/assets/js/modals/photo.js';
                
                // Get photos of Ad
                $ad_id = Input::has('ad_id') ? Input::get('ad_id') : '';
                $records = null;
                $records = File::where();
                
                $this->page['photos'] = $records;
            break;
        }
        
        $this->page['type']         = $type;
        $this->page['asset_css']    = $asset_css;
        $this->page['asset_script'] = $asset_script;
    }

}