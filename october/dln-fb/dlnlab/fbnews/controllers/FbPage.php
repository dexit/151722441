<?php namespace DLNLab\FBNews\Controllers;

use BackendMenu;
use Flash;
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
            if ($FbPage['type'] == 'user') {
                $obj = FbPageModel::get_fb_profile_infor($FbPage['fb_link']);
            } else {
                $obj = FbPageModel::get_fb_page_infor($FbPage['fb_link']);
            }
        }
    }
    
    public function index_onApproved() {
		if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            $ids = implode(',', $checkedIds);
			if ( $ids ) {
				FbPageModel::whereRaw("id IN ({$ids})")->update(array('status' => 1));
			}

            Flash::success('Successfully approved those reports.');
        }

        return $this->listRefresh();
	}
	
	public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $reportId) {
                if ((! $record = FbPageModel::find($reportId)))
                    continue;

                $record->delete();
            }

            Flash::success('Successfully deleted those reports.');
        }

        return $this->listRefresh();
    }
}