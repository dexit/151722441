<?php namespace DLNLab\Features\Components;

use Auth;
use Redirect;
use Validator;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use October\Rain\Support\ValidationException;
use DLNLab\Features\Models\Report;

class ReportForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'ReportForm Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
			'report_type' => [
                'title'       => 'Report Type',
                'description' => 'Report Type Desc',
                'type'        => 'string',
                'default'     => 'ad'
            ],
			'redirect' => [
                'title'       => 'rainlab.user::lang.account.redirect_to',
                'description' => 'rainlab.user::lang.account.redirect_to_desc',
                'type'        => 'dropdown',
                'default'     => ''
            ],
		];
    }
	
	public function getRedirectOptions()
    {
        return [''=>'- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
	
	public function onRun()
    {
		$this->page['report_type'] = $this->property('report_type');
        $this->page['user'] = $this->user();
    }
	
	public static function onSendReport($is_rest = false)
	{
		if (!Auth::check() && !$is_rest)
            return null;
		
		if (!Auth::check() && $is_rest)
            return 'Bad Request!';
		
		$data = post();
		$rules = [
			'item_id' => 'required|numeric',
			'content'   => 'required',
			'type'      => 'required',
		];
		
		$validation = Validator::make($data, $rules);
        if ($validation->fails() && !$is_rest)
            throw new ValidationException($validation);
		
		if ($validation->fails() && $is_rest) {
			return $validation->messages()->first();
		}
		
		try {
			$report = new Report();
			$report->content   = $data['content'];
			$report->user_id   = Auth::getUser()->id;
			$report->item_id   = $data['item_id'];
			$report->type      = $data['type'];
			$report->save();
		} catch (Exception $ex) {
			if ($is_rest) {
				return $ex->getMessage();
			}
		}
		
		
		if (! $is_rest) {
			/*
			 * Redirect to the intended page after successful sign in
			 */
			$redirectUrl = $this->pageUrl($this->property('redirect'));

			if ($redirectUrl = post('redirect', $redirectUrl))
				return Redirect::intended($redirectUrl);
		} else {
			return null;
		}
	}

}