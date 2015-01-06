<?php namespace DLNLab\Classified\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use DLNLab\Classified\Models\AdTag as AdTagModel;

/**
 * Ad_Tag Back-end Controller
 */
class AdTag extends Controller
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

        BackendMenu::setContext('DLNLab.Classified', 'classified', 'ad_tag');
    }
	
	public function onCalcAdTagCount()
    {
        $tag_id = post('id');
        if ( ! $tag_id ) {
            return false;
        }
        AdTagModel::updateCount($tag_id);
        return true;
    }
}