<?php namespace DLNLab\Classified\Components;

use Auth;
use Cms\Classes\ComponentBase;

class HeaderBar extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'HeaderBar Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    
    public function onRun() {
        $user = $this->user();
        if (! $user)
            return false;
        
        $name       = trim($user->name);
        $parts      = explode(" ", $name);
        $last_name  = array_pop($parts);
        $first_name = implode(" ", $parts);
        $path       = (! empty($user->avatar)) ? $user->avatar->getPath() : '';
        
        $this->page['user']       = $user;
        $this->page['last_name']  = $last_name;
        $this->page['first_name'] = $first_name;
        $this->page['avatar']     = $path;
        
        $asset_script[] = '~/plugins/dlnlab/classified/assets/js/components/headerbar.js';
        $asset_css[]    = '~/plugins/dlnlab/classified/assets/css/components/headerbar.css';
        $this->page['asset_css']    = $asset_css;
        $this->page['asset_script'] = $asset_script;
        
        $this->page['types']      = HelperCache::getAdType();
        $this->page['categories'] = HelperCache::getAdCategory();
        $this->page['amenities']  = HelperCache::getAdAmenities();
        $this->page['bed_rooms']  = AdInfor::getBedRoomOptions();
        $this->page['bath_rooms'] = AdInfor::getBathRoomOptions();
        $this->page['directions'] = AdInfor::getDirectionOptions();
    }
    
    public function user()
    {
        if (!Auth::check())
            return null;
    
        return Auth::getUser();
    }

}