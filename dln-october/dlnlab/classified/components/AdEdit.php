<?php namespace DLNLab\Classified\Components;

use Auth;
use Redirect;
use Response;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use DLNLab\Classified\Models\Ad;
use DLNLab\Classified\Models\AdInfor;
use DLNLab\Classified\Models\Tag;
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
                $ad_tags  = Tag::getTagsOfAd($ad_id);
                $this->page['ad']         = $ad;
                $this->page['ad_infor']   = $ad_infor;
                $this->page['ad_tags']    = $ad_tags;
                break;
            case 'edit-detail':
                $kind     = HelperCache::getAdKind();
                $category = HelperCache::getAdCategory();
                $amenity  = HelperCache::getAdAmenities();
                $bed_rooms  = AdInfor::getBedRoomOptions();
                $bath_rooms = AdInfor::getBathRoomOptions();
                $direction  = AdInfor::getDirectionOptions();
                $caches            = new \stdClass;
                $caches->kind      = (! empty($kind)) ? $kind->toJson() : '';
                $caches->category  = (! empty($category)) ? $category->toJson() : '';
                $caches->amenity   = (! empty($amenity)) ? $amenity->toJson() : '';
                $caches->bed       = json_encode($bed_rooms);
                $caches->bath      = json_encode($bath_rooms);
                $caches->direction = json_encode($direction);

                $this->page['user']       = $this->user();
                $this->page['ad']         = (! empty($ad)) ? $ad : '';
                $this->page['ad_json']    = (! empty($ad)) ? $ad->toJson() : '';
                $this->page['dln_caches'] = (! empty($caches)) ? json_encode($caches) : '';
                break;
        }
        $this->page['type'] = $type;
	    
	}
}