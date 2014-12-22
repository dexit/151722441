<?php

namespace DLNLab\Classified\Components;

use Cms\Classes\ComponentBase;

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
		$this->ad = $this->page['ad'] = $this->loadAd();
	}

	protected function loadAd() {
		// @deprecated remove if year >= 2015
        $deprecatedSlug = $this->propertyOrParam('idParam');

        $slug = $this->property('slug', $deprecatedSlug);
        $post = Ad::where('slug', '=', $slug)->first();
		var_dump($post);die();

        /*
         * Add a "url" helper attribute for linking to each category
         */
        /*if ($post && $post->categories->count()) {
            $post->categories->each(function($category){
                $category->setUrl($this->categoryPage, $this->controller);
            });
        }*/

        return $post;
	}

}
