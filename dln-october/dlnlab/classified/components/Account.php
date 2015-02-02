<?php namespace DLNLab\Classified\Components;

use Auth;
use Mail;
use Flash;
use Input;
use Redirect;
use Response;
use Validator;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use October\Rain\Support\ValidationException;
use RainLab\User\Models\Settings as UserSettings;
use Exception;

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
        //$this->addJs(CLF_ASSETS . '/js/com-account-register.js', 'core');
        //$this->addCss(CLF_ASSETS . '/css/com-account.css', 'core');
        
        $this->page['user'] = $this->user();
        $this->page['type'] = $this->property('type', 'register');
    }

    public function user()
    {
        if (!Auth::check())
            return null;
    
        return Auth::getUser();
    }
    
    public function onRegister()
    {
        /*
         * Validate input
        */
        $data = post();
        
        if (! array_key_exists('confirm_password', Input::all()))
            $data['confirm_password'] = post('password');
    
        $rules = [
            'email'    => 'required|email|between:2,64',
            'password' => 'required|min:2'
        ];
    
        $loginAttribute = UserSettings::get('login_attribute', UserSettings::LOGIN_EMAIL);
        if ($loginAttribute == UserSettings::LOGIN_USERNAME)
            $rules['username'] = 'required|between:2,64';
    
        $validation = Validator::make($data, $rules);
        if ($validation->fails())
            throw new ValidationException($validation);
    
        try {
            /*
             * Register user
            */
            $requireActivation = UserSettings::get('require_activation', true);
            $automaticActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_AUTO;
            $userActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_USER;
            $user = Auth::register($data, $automaticActivation);
        
            /*
             * Activation is by the user, send the email
            */
            if ($userActivation) {
                $this->sendActivationEmail($user);
            }
        
            /*
             * Automatically activated or not required, log the user in
            */
            if ($automaticActivation || !$requireActivation) {
                Auth::login($user);
            }
        } catch (Exception $e) {
            $data = array(
                'status' => 'error',
                'message' => $e->getMessage()
            );
            return Response::json($data, 500);
        }
    
        /*
         * Redirect to the intended page after successful sign in
        */
        $redirectUrl = $this->pageUrl($this->property('redirect'));
    
        if ($redirectUrl = post('redirect', $redirectUrl))
            return Redirect::intended($redirectUrl);
    }

    public static function onSignin()
    {
        /*
         * Validate input
        */
        $data = post();
        $rules = [
            'password' => 'required|min:2'
        ];
    
        $loginAttribute = UserSettings::get('login_attribute', UserSettings::LOGIN_EMAIL);
    
        if ($loginAttribute == UserSettings::LOGIN_USERNAME)
            $rules['login'] = 'required|between:2,64';
        else
            $rules['login'] = 'required|email|between:2,64';
    
        if (!in_array('login', $data))
            $data['login'] = post('username', post('email'));
    
        $validation = Validator::make($data, $rules);
        if ($validation->fails())
            throw new ValidationException($validation);
    
        /*
         * Authenticate user
        */
        try {
            $user = Auth::authenticate([
                'login' => array_get($data, 'login'),
                'password' => array_get($data, 'password')
            ], true);
        } catch (Exception $e) {
            throw $e;
        }
    
        /*
         * Redirect to the intended page after successful sign in
        */
        $redirectUrl = $this->pageUrl($this->property('redirect'));
    
        if ($redirectUrl = post('redirect', $redirectUrl))
            return Redirect::intended($redirectUrl);
    }
}