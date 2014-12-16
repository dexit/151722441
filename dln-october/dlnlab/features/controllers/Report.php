<?php namespace DLNLab\Features\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Report Back-end Controller
 */
class Report extends Controller
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

        BackendMenu::setContext('DLNLab.Features', 'features', 'report');
    }
}