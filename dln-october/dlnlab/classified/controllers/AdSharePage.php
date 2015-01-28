<?php namespace DLNLab\Classified\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use DLNLab\Classified\Models\UserAccessToken;
use DLNLab\Classified\Models\AdSharePage as AdSharePageModel;

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
        
        $obj = array();
        if (! empty($AdSharePage['fb_link'])) {
            $obj = UserAccessToken::get_fb_page_infor($AdSharePage['fb_link']);
        }
    }
}