<?php namespace DLNLab\Classified\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * AdSharePage Back-end Controller
 */
class AdSharePage extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    
    public $recordId   = null;

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('DLNLab.Classified', 'classified', 'adsharepage');
    }
    
    public function onGetFBPageInfor()
    {
        $post = post();
        
        extract($post);
        
        var_dump($link);die();
    }
}