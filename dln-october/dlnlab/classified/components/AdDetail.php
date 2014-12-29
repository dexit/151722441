<?php

namespace DLNLab\Classified\Components;

use Cms\Classes\ComponentBase;
use DLNLab\Classified\Models\Ad;

class AdDetail extends ComponentBase {

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
		$this->addJs(CLF_ASSETS . '/js/com-ad-detail.js');
		$this->ad = $this->page['ad'] = $this->loadAd();
	}

	protected function loadAd() {
		// @deprecated remove if year >= 2015
        $deprecatedSlug = $this->propertyOrParam('idParam');

        $slug = $this->property('slug', $deprecatedSlug);
        $ad   = Ad::where('slug', '=', $slug)->first();

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

}