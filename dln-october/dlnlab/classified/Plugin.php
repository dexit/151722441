<?php

namespace DLNLab\Classified;

use Request;
use Backend;
use Controller;
use Event;
use System\Classes\PluginBase;

define( 'CLF_ASSETS', '/plugins/dlnlab/classified/assets' );
define( 'CLF_ROOT',  dirname(__FILE__) );
define( 'CLF_UPLOAD', __DIR__ . '/uploads/' );
define( 'OCT_ROOT', Request::root() );
define( 'CLF_CACHE', 3600 );
define( 'CLF_LIMIT_AD_PRIVATE', 30 );
define( 'TIME_DELAY_COUNT_VIEW', 420 ); // 7 minutes
define( 'CLF_MESSAGES', json_encode(array(
        'required'  => ':attribute bị thiếu',
        'array'     => ':attribute phải đúng dạng array',
        'between'   => ':attribute phải nằm trong khoảng :min - :max số.',
        'numeric'   => ':attribute phải dùng dạng số',
        'alpha_num' => ':attribute không được có ký tự đặc biệt',
        'size'      => ':attribute bị giới hạn :size ký tự',
        'min'       => ':attribute phải lớn hơn :min',
        'max'       => ':attribute phải nhỏ hơn :max',
        'regex'     => ':attribute không hợp lệ',
    ))
);

/**
 * Classified Plugin Information File
 */
class Plugin extends PluginBase {
    
	/**
	 * Returns information about this plugin.
	 *
	 * @return array
	 */
	public function pluginDetails() {
		return [
			'name' => 'Classified',
			'description' => 'No description provided yet...',
			'author' => 'DLNLab',
			'icon' => 'icon-leaf'
		];
	}

	public function registerNavigation() {
		return [
			'classified' => [
				'label' => 'dlnlab.classified::lang.ad.menu_label',
				'url' => Backend::url('dlnlab/classified/ad'),
				'icon' => 'icon-photo',
				'permissions' => ['dlnlab.classified.*'],
				'order' => 500,
				'sideMenu' => [
					'ad' => [
						'label' => 'dlnlab.classified::lang.ad.menu_label',
						'icon' => 'icon-copy',
						'url' => Backend::url('dlnlab/classified/ad'),
						'permissions' => ['dlnlab.classified.access_ad'],
					],
					'ad_categories' => [
						'label' => 'dlnlab.classified::lang.ad.categories',
						'icon' => 'icon-list-ul',
						'url' => Backend::url('dlnlab/classified/adcategories'),
						'permissions' => ['rainlab.blog.access_ad_categories'],
					],
					'tag' => [
						'label' => 'Tags',
						'icon' => 'icon-list-ul',
						'url' => Backend::url('dlnlab/classified/tag'),
					],
                    'ad_share_page' => [
                        'label' => 'Share Pages',
                        'icon' => 'icon-list-ul',
                        'url' => Backend::url('dlnlab/classified/adsharepage'),
                    ]
				]
			]
		];
	}

	public function registerComponents() {
		return [
			'DLNLab\Classified\Components\AdDetail' => 'AdDetail',
			'DLNLab\Classified\Components\AdList'   => 'AdList',
			'DLNLab\Classified\Components\AdEdit'   => 'AdEdit',
			'DLNLab\Classified\Components\AdCookie' => 'AdCookie',
			'DLNLab\Classified\Components\Account'  => 'Account',
			'DLNLab\Classified\Components\HeaderBar' => 'HeaderBar',
		];
	}

	public function registerMarkupTags()
	{
	    return [
	        'functions' => [
        	    'dump' => 'var_dump',
        	    'dd' => 'dd',
                'csrf_token' => [$this, 'createCsrfToken']
    	    ]
	    ];
	}
    
    public function createCsrfToken() {
        echo '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}
