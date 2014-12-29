<?php namespace DLNLab\Features\Components;

use Auth;
use Input;
use Crypt;
use Session;
use Cms\Classes\ComponentBase;

class ActionValidReward extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'ActionValidReward Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
	
	public function onRun() {
		//$this->page['encrypted'] = Session::token();
		
		/*if ( ! Input::has('check_reward') || empty( Input::get('check_reward') ) )
			return;
		
		if (Input::has('dln_referer_code') && Auth::check()) {
			$current_user_id = Auth::getUser()->id;
			$referer_code    = Input::get('dln_referer_code');
			if ($current_user_id == $referer_code)
				return false;
			
			// Update referer for user
		}*/
		
	}

}