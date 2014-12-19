<?php namespace DLNLab\Features\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use DLNLab\Features\Models\Notification;

/**
 * Moneys Back-end Controller
 */
class Moneys extends Controller
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

        BackendMenu::setContext('DLNLab.Features', 'features', 'moneys');
    }
}