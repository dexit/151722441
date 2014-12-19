<?php namespace DLNLab\Features\Controllers;

use DB;
use Flash;
use BackendMenu;
use Backend\Classes\Controller;
use DLNLab\Features\Models\Report;

/**
 * Report Back-end Controller
 */
class Reports extends Controller
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

        BackendMenu::setContext('DLNLab.Features', 'features', 'reports');
    }
	
	public function index() {
		$this->vars['reportUnread'] = Report::where('status', 0)->count();
		
		$this->asExtension('ListController')->index();
	}
	
	public function index_onApproved() {
		if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            $ids = implode(',', $checkedIds);
			if ( $ids ) {
				Report::whereRaw("id IN ({$ids})")->update(array('status' => 1));
			}

            Flash::success('Successfully approved those reports.');
        }

        return $this->listRefresh();
	}
	
	public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $reportId) {
                if ((!$report = Report::find($reportId)) || !$report->canEdit($this->user))
                    continue;

                $post->delete();
            }

            Flash::success('Successfully deleted those reports.');
        }

        return $this->listRefresh();
    }
}