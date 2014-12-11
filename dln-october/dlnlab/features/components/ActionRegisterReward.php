<?php namespace DLNLab\Features\Components;

use Auth;
use Input;
use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;

class ActionRegisterReward extends ComponentBase
{

    public function componentDetails() {
		return [
			'name' => 'actionRegisterReward Component',
			'description' => 'No description provided yet...'
		];
	}

	public function defineProperties() {
		return [
			'redirect' => [
				'title' => 'Redirect',
				'description' => 'Redirect Desc',
				'type' => 'dropdown',
				'default' => ''
			]
		];
	}

	public function getRedirectOptions() {
		return ['' => '- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
	}

	public function onRun() {
		if ( ! Input::has('referer') || empty( Input::get('referer') ) )
			return;
		// For reward referer friend case
		caseRefererFriend();
		
		
	}
	
	private function caseRefererFriend() {
		$referer = Input::get('referer');

		// Save code referer to session
		setcookie( 'dln_referer_code', $referer, 0, "/" );

		// Get redirect url
		$redirectUrl = $this->property( 'redirect' );
		
		$isAuthenticated = Auth::check();
		if ( ! $isAuthenticated )
			return Redirect::to( $redirectUrl );
	}

}