<?php namespace DLNLab\Classified\Components;

use Auth;
use Cache;
use Redirect;
use Response;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use DLNLab\Classified\Models\Tag;
use DLNLab\Classified\Models\AdCategory;

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
		//$this->addCss(CLF_ASSETS . '/css/com-ad-edit.css');
		
	    
	    $this->page['type']       = $this->property('type', 'quick');
	    $this->page['kinds']      = $this->getKindTagOptions();
	    $this->page['categories'] = $this->getAdCategoryOptions();
	}
	
	public function getAdCategoryOptions() {
	    $options = '';
	    if (! Cache::has('ad_category')) {
	        $options = AdCategory::all();
	        Cache::put('ad_category', $options, 3600);
	    } else {
	        $options = Cache::get('ad_category');
	    }
	    return $options;
	}
	
	public function getKindTagOptions() {
	    $options = '';
	    if (! Cache::has('kind_options')) {
	        $options = Tag::getTagByType('ad_kind');
	        Cache::put('kind_options', $options, 3600);
	    } else {
	        $options = Cache::get('kind_options');
	    }
	    return $options;
	}

}