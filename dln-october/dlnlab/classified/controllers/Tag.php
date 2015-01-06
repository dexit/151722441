<?php namespace DLNLab\Classified\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use DLNLab\Classified\Models\Tag as TagModel;

/**
 * Tag Back-end Controller
 */
class Tag extends Controller
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

        BackendMenu::setContext('DLNLab.Classified', 'classified', 'tag');
    }
	
	public function onCalcAdTagCount()
    {
        $tag_id = post('id');
        if ( ! $tag_id ) {
            return false;
        }
        TagModel::updateCount($tag_id);
        return true;
    }
}