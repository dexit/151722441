<?php

namespace DLNLab\Classified\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use DLNLab\Classified\Models\Ad;

class AdList extends ComponentBase {

	public function componentDetails() {
		return [
			'name' => 'AdList Component',
			'description' => 'No description provided yet...'
		];
	}

	public function defineProperties() {
		return [
			'pageParam' => [
				'title' => 'rainlab.blog::lang.settings.posts_pagination',
				'description' => 'rainlab.blog::lang.settings.posts_pagination_description',
				'type' => 'string',
				'default' => ':page',
			],
			'categoryFilter' => [
				'title' => 'rainlab.blog::lang.settings.posts_filter',
				'description' => 'rainlab.blog::lang.settings.posts_filter_description',
				'type' => 'string',
				'default' => ''
			],
			'AdsPerPage' => [
				'title' => 'rainlab.blog::lang.settings.posts_per_page',
				'type' => 'string',
				'validationPattern' => '^[0-9]+$',
				'validationMessage' => 'rainlab.blog::lang.settings.posts_per_page_validation',
				'default' => '10',
			],
			'AdOrderAttr' => [
				'title' => 'rainlab.blog::lang.settings.posts_order',
				'description' => 'rainlab.blog::lang.settings.posts_order_description',
				'type' => 'dropdown',
				'default' => 'published_at desc'
			],
			'categoryPage' => [
				'title' => 'rainlab.blog::lang.settings.posts_category',
				'description' => 'rainlab.blog::lang.settings.posts_category_description',
				'type' => 'dropdown',
				'default' => 'blog/category',
				'group' => 'Links',
			],
			'adPage' => [
				'title' => 'Ad Page',
				'description' => 'Ad Page Description',
				'type' => 'dropdown',
				'default' => 'ad/post',
				'group' => 'Links',
			],
            'type' => [
                'title'       => 'Type',
                'description' => 'Desc',
                'type'        => 'dropdown',
                'default'     => 'quick'
            ]
		];
	}
	
	public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
	
	public function getAdPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

	public function onRun() {
		$this->prepareVars();

        $type = $this->property('type');
        switch ($type) {
            case 'list_ad_user':
                $this->page['ads'] = $this->listAdsUser();
                break;
            default:
                $this->category = $this->page['category'] = $this->loadCategory();
                $this->ads      = $this->page['ads']      = $this->listAds();
                $type = 'list_default';
                break;
        }
        $this->type     = $type;

		$currentPage = $this->propertyOrParam('pageParam');
		if ($currentPage > ($lastPage = $this->ads->getLastPage()) && $currentPage > 1)
			return Redirect::to($this->controller->currentPageUrl([$this->property('pageParam') => $lastPage]));
	}
	
	protected function prepareVars() {
		$this->pageParam    = $this->page['pageParam']    = $this->property('pageParam', 'page');
		$this->noAdMessage  = $this->page['noAdMessage']  = $this->property('noAdMessage');

		$this->adPage       = $this->page['adPage']       = $this->property('adPage');
		$this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
	}
	
    protected function listAdsUser() {
        $user = Auth::getUser();
        
        $ads = Ad::whereRaw('user_id = ?')->listUser([
            'page' => $this->propertyOrParam('pageParam'),
            'perPage' => $this->property('AdsPerPage')
        ]);
    }
    
	protected function listAds() {
		$categories = $this->category ? $this->category->id : null;
		
		$ads = Ad::with('category')->listFrontEnd([
			'page' => $this->propertyOrParam('pageParam'),
			'sort' => $this->property('AdOrderAttr'),
			'perPage' => $this->property('AdsPerPage'),
			'categories' => $categories 
		]);

		$ads->each(function($ad) {
			$ad->setUrl($this->adPage, $this->controller);

			//$ad->categories->each(function ($category) {
			//    $category->setUrl($this->categoryPage, $this->controller);
			//});
		});

		return $ads;
	}
	
	protected function loadCategory() {
		if (!$category_id = $this->propertyOrParam('categoryFilter'))
			return null;

		if (!$category = AdCategory::whereSlug($category_id)->first())
			return null;

		return $category;
	}

}
