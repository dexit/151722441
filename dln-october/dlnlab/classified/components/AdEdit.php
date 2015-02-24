<?php namespace DLNLab\Classified\Components;

use Auth;
use Redirect;
use Response;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use DLNLab\Classified\Classes\HelperCache;

class AdEdit extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'AdEdit Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'redirect' => [
                'title'       => 'Redirect',
                'description' => 'Redirect description',
                'type'        => 'dropdown',
                'default'     => ''
            ],
            'type' => [
                'title'       => 'Type',
                'description' => 'Desc',
                'type'        => 'dropdown',
                'default'     => 'quick'
            ]
        ];
    }
    
    public function getRedirectOptions()
    {
        return [''=>'- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
    
    public function getTypeOptions() {
        return array(
            'edit'  => 'Edit',
            'quick' => 'Quick'
        );
    }
	
	public function onRun() {
		//$this->addJs('http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=vi');
		//$this->addJs(CLF_ASSETS . '/js/helper-googlemap.js');
		//$this->addJs(CLF_ASSETS . '/js/com-ad-edit.js');
		$this->addCss(CLF_ASSETS . '/css/com-ad-edit.css');
		$type = $this->property('type', 'quick');
        switch ($type) {
            case 'quick':
                $asset_script[] = '~/plugins/dlnlab/classified/assets/js/components/ad-quick.js';
                break;
            case 'edit':
                $asset_script[] = '~/plugins/dlnlab/classified/assets/js/components/ad-edit2.js';
                break;
        }
        $this->page['type']      = $type;
	    $this->page['kinds']      = HelperCache::getAdKind();
	    $this->page['categories'] = HelperCache::getAdCategory();
	    
	}
}