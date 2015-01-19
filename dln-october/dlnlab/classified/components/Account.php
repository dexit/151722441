<?php namespace DLNLab\Classified\Components;

use Auth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;

class Account extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Account Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'redirect' => [
                'title'       => 'Redirect',
                'description' => 'Redirect description',
                'type'        => 'dropdown',
                'default'     => ''
            ],
            'paramCode' => [
                'title'       => 'parameter code',
                'description' => 'parameter code desc',
                'type'        => 'string',
                'default'     => 'code'
            ],
            'type' => [
                'title'       => 'Type',
                'description' => 'Desc',
                'type'        => 'dropdown',
                'default'     => 'register'
            ]
        ];
    }
    
    public function getRedirectOptions()
    {
        return [''=>'- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
    
    public function getTypeOptions() {
        return array(
            'register' => 'Register',
            'login'    => 'Login'
        );
    }
    
    public function onRun() {
        //$this->addJs(CLF_ASSETS . '/js/com-account-register.js');
        $this->addCss(CLF_ASSETS . '/css/com-account.css');
        
        $this->page['user'] = $this->user();
        $this->type = $this->property('type', 'register');
    }

    public function user()
    {
        if (!Auth::check())
            return null;
    
        return Auth::getUser();
    }
    
}