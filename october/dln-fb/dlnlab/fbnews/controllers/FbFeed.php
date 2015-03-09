<?php namespace DLNLab\FBNews\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * FbFeed Back-end Controller
 */
class FbFeed extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('DLNLab.FBNews', 'fbnews', 'fbfeed');
    }
}