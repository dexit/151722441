<?php namespace DLNLab\FBNews\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use DLNLab\FBNews\Models\FbPage as FbPageModel;

/**
 * FbPage Back-end Controller
 */
class FbPage extends Controller
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

        BackendMenu::setContext('DLNLab.FBNews', 'fbnews', 'fbpage');
    }
    
    public function onGetFBPageInfor()
    {
        $post = post();
        
        extract($post);
        
        $obj = array();
        if (! empty($FbPage['fb_link'])) {
            $obj = FbPageModel::get_fb_page_infor($FbPage['fb_link']);
        }
    }
}