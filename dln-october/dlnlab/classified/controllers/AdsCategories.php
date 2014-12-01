<?php namespace DLNLab\Classified\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use DLNLab\Classified\Models\AdsCategory;

/**
 * AdsCategories Back-end Controller
 */
class AdsCategories extends Controller
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

        BackendMenu::setContext('DLNLab.Classified', 'classified', 'adscategories');
    }

    public function update($recordId, $context = null)
    {
        $this->recordId = $recordId;

        // Call the FormController behavior update() method
        return $this->asExtension('FormController')->update($recordId, $context);
    }

    public function onCalcAdsCount()
    {
        $category_id = post('id');
        if ( ! $category_id ) {
            return false;
        }
        AdsCategory::updateCountCategory($category_id);
        return true;
    }
}