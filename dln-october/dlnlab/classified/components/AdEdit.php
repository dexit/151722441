<?php namespace DLNLab\Classified\Components;

use Cms\Classes\ComponentBase;

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
        return [];
    }
	
	public function onRun() {
		$this->addJs('http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=vi');
		$this->addJs(CLF_ASSETS . '/js/field-map.js');
		$this->addJs(CLF_ASSETS . '/js/com-ad-edit.js');
		$this->addCss(CLF_ASSETS . '/css/com-ad-edit.css');
	}

}