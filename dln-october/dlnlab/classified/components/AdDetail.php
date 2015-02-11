<?php

namespace DLNLab\Classified\Components;

use Auth;
use Cms\Classes\ComponentBase;
use DLNLab\Classified\Models\Ad;
use DLNLab\Classified\Classes\HelperCache;

class AdDetail extends ComponentBase {
    
    public $allow_edit = true;

	public function componentDetails() {
		return [
			'name' => 'AdDetail Component',
			'description' => 'No description provided yet...'
		];
	}

	public function defineProperties() {
		return [
			'slug' => [
				'title' => 'rainlab.blog::lang.settings.post_slug',
				'description' => 'rainlab.blog::lang.settings.post_slug_description',
				'default' => '{{ :slug }}',
				'type' => 'string'
			]
		];
	}

	public function onRun() {
		//$this->addJs(CLF_ASSETS . '/js/helpers/ad-cache.js');
        //$this->addJs(CLF_ASSETS . '/js/helpers/ad-helper.js');
        //$this->addJs(CLF_ASSETS . '/js/components/ad-detail.js');
		
		$ad       = $this->loadAd();
		$kind     = HelperCache::getAdKind();
		$category = HelperCache::getAdCategory();
		$amenity  = HelperCache::getAdAmenities();
        $caches           = new \stdClass;
        $caches->kind     = (! empty($kind)) ? $kind->toJson() : '';
        $caches->category = (! empty($category)) ? $category->toJson() : '';
        $caches->amenity  = (! empty($amenity)) ? $amenity->toJson() : '';
		
		$this->page['user']       = $this->user();
		$this->page['ad']         = (! empty($ad)) ? $ad : '';
		$this->page['ad_json']    = (! empty($ad)) ? $ad->toJson() : '';
        $this->page['dln_caches'] = (! empty($caches)) ? json_encode($caches) : '';
	}

	protected function loadAd() {
		// @deprecated remove if year >= 2015
        $deprecatedSlug = $this->propertyOrParam('idParam');

        $slug     = $this->property('slug', $deprecatedSlug);
        $arr_slug = preg_split('/-(?=\d+$)/', $slug);
        if (count($arr_slug) < 2)
            return false;
        
        $slug    = $arr_slug[0];
        $ad_id   = $arr_slug[1];
        if ($ad_id == 0)
            return false;
        
        $ad = Ad::find($ad_id);
        if ($ad->user_id == Auth::getUser()->id)
            $this->allow_edit = true;

        /*
         * Add a "url" helper attribute for linking to each category
         */
        /*if ($post && $post->categories->count()) {
            $post->categories->each(function($category){
                $category->setUrl($this->categoryPage, $this->controller);
            });
        }*/

        return $ad;
	}
    
    public function user()
    {
        if (!Auth::check())
            return null;
    
        return Auth::getUser();
    }

}
