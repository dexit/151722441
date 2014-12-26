<?php namespace DLNLab\Classified\Components;

use Auth;
use Cookie;
use Session;
use Cms\Classes\ComponentBase;
use DLNLab\Classified\Models\Ad;
use DLNLab\Classified\Models\AdRead;

class AdCookie extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'AdCookie Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
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
		if (Session::has('disable_cookie'))
			return false;
			
		if (!Auth::check())
            return null;
		$user = Auth::getUser();
		
		// @deprecated remove if year >= 2015
        $deprecatedSlug = $this->propertyOrParam('idParam');

        $slug = $this->property('slug', $deprecatedSlug);
        $item = Ad::isPublished()->where('slug', '=', $slug)->first();
		
		if (empty($item))
			return null;
		
		// Get current ad cookie
		$cookie_obj = new \stdClass;
		$cookie     = Cookie::get('dln_ads_cookie');
		
		if ($cookie) {
			// Check current user has exist in cookie
			$cookie_obj   = json_decode($cookie);
			$current_time = time();
			
			if (!empty($cookie_obj->{$item->id}) && $cookie_obj->{$item->id}) {
				if ($current_time >= ($cookie_obj->{$item->id} + TIME_DELAY_COUNT_VIEW)) {
					$cookie_obj->{$item->id} = time();
					$cookie = json_encode($cookie_obj);
					Cookie::queue('dln_ads_cookie', $cookie, 1440);
					AdRead::add_read($item->id, $user);
				}
			} else {
				$cookie_obj->{$item->id} = time();
				$cookie = json_encode($cookie_obj);
				Cookie::queue('dln_ads_cookie', $cookie, 1440);
				AdRead::add_read($item->id, $user);
			}
		} else {
			$cookie_obj->{$item->id} = time();
			$cookie = json_encode($cookie_obj);
			Cookie::queue('dln_ads_cookie', $cookie, 1440);
			AdRead::add_read($item->id, $user);
		}
	}

}