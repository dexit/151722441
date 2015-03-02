<?php

namespace DLNLab\Classified\Classes;

use Cache;
use DLNLab\Classified\Models\Tag;
use DLNLab\Classified\Models\AdCategory;

class HelperCache {
    
    public static function getAdCategory() {
	    $options = '';
	    if (! Cache::has('ad_category')) {
	        $options = AdCategory::get(array('id', 'name', 'slug'));
	        Cache::put('ad_category', $options, CLF_CACHE);
	    } else {
	        $options = Cache::get('ad_category');
	    }
	    
	    return $options;
	}
    
    public static function findAdCategoryById($id) {
        if (! $id)
            return false;
        $categories = self::getAdCategory();
        foreach ($categories as $i => $category) {
            if ($id == $category->id) {
                return $category;
            }
        }
        return false;
    }
	
	public static function getAdType() {
	    return array(
            '1' => 'Bán',
	        '2' => 'Cho thuê'
        );
	}
    
    public static function getAdAmenities() {
        $options = '';
        if (! Cache::has('amenities_options')) {
            $options = Tag::getTagByType('ad_amenities');
            Cache::put('amenities_options', $options, CLF_CACHE);
        } else {
            $options = Cache::get('amenities_options');
        }
        
        return $options;
    }
    
    public static function findAdAmenityById($id) {
        if (! $id)
            return false;
        
        $options = self::getAdAmenities();
        foreach ($options as $i => $option) {
            if ($id == $option->id) {
                return $option;
            }
        }
        return false;
    }
    
    public static function findAdTagById($id) {
        if (! $id)
            return false;
        
        $option = self::findAdAmenityById($id);
        
        return $option;
    }
    
}