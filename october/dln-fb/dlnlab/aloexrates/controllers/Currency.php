<?php namespace DLNLab\AloExrates\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Currency Back-end Controller
 */
class Currency extends Controller
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

        BackendMenu::setContext('DLNLab.AloExrates', 'aloexrates', 'currency');
    }
}