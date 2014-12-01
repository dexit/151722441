<?php namespace DLNLab\Classified\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Ads Back-end Controller
 */
class Ads extends Controller
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

        BackendMenu::setContext('DLNLab.Classified', 'classified', 'ads');
    }
}