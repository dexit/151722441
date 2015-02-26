<?php namespace DLNLab\Classified\Components;

use Auth;
use Redirect;
use Response;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use DLNLab\Classified\Models\Ad;
use DLNLab\Classified\Models\AdInfor;
use DLNLab\Classified\Classes\HelperCache;

class AdEdit extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'AdEdit Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'redirect' => [
                'title'       => 'Redirect',
                'description' => 'Redirect description',
                'type'        => 'dropdown',
                'default'     => ''
            ],
            'type' => [
                'title'       => 'Type',
                'description' => 'Desc',
                'type'        => 'dropdown',
                'default'     => 'quick'
            ]
        ];
    }
    
    public function getRedirectOptions()
    {
        return [''=>'- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
    
    public function getTypeOptions() {
        return array(
            'edit'  => 'Edit',
            'quick' => 'Quick'
        );
    }
	
	public function onRun() {
		//$this->addJs('http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=vi');
		//$this->addJs(CLF_ASSETS . '/js/helper-googlemap.js');
		//$this->addJs(CLF_ASSETS . '/js/com-ad-edit.js');
		$this->addCss(CLF_ASSETS . '/css/com-ad-edit.css');
		$type = $this->property('type', 'quick');
        switch ($type) {
            case 'quick':
                break;
            case 'edit':
                //$asset_script[] = '~/plugins/dlnlab/classified/assets/js/components/ad-edit2.js';
                break;
            case 'edit2':
                $ad_id = intval($this->param('ad_id'));
                if (empty($ad_id)) {
                    Redirect::to('/ad/quick');
                }
                $ad       = Ad::find($ad_id);
                $ad_infor = AdInfor::where('ad_id', '=', $ad_id);
                $ad_tag   = DB::table('dlnlab_classified_ads_tags')->where('ad_id', '=', $ad_id)->get();
                $this->page['ad']         = $ad;
                $this->page['ad_infor']   = $ad_infor;
                $this->page['ad_tag']     = $ad_tag;
                $this->page['types']      = HelperCache::getAdType();
                $this->page['categories'] = HelperCache::getAdCategory();
                $this->page['amenities']  = HelperCache::getAdAmenities();
                $this->page['bed_rooms']  = AdInfor::getBedRoomOptions();
                $this->page['bath_rooms'] = AdInfor::getBathRoomOptions();
                $this->page['directions'] = AdInfor::getDirectionOptions();
                break;
        }
        $this->page['type'] = $type;
	    
	}
}