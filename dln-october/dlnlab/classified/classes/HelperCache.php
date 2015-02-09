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
	
	public static function getAdKind() {
	    $options = '';
	    if (! Cache::has('kind_options')) {
	        $options = Tag::getTagByType('ad_kind');
	        Cache::put('kind_options', $options, CLF_CACHE);
	    } else {
	        $options = Cache::get('kind_options');
	    }

	    return $options;
	}
    
    public static function findAdKindById($id) {
        if (! $id)
            return false;
        $options = self::getAdKind();
        foreach ($options as $i => $option) {
            if ($id == $option->id) {
                return $option;
            }
        }
        return false;
    }
    
    public static function getAdAmenities() {
        $options = '';
        if (Cache::has('amenities_options')) {
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
        
        $option = self::findAdKindById($id);
        if (! $option) {
            $option = self::findAdAmenityById($id);
        }
        return $option;
    }
    
}