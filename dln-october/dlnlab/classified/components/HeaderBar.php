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
        $this->page['user'] = '123';
    }
    
    public function user()
    {
        if (!Auth::check())
            return null;
    
        return Auth::getUser();
    }

}