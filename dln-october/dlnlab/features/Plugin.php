<?php namespace DLNLab\Features;

use Backend;
use Controller;
use Event;
use System\Classes\PluginBase;

define( 'TWILIO_ACCOUNT', 'ACbc7ac7f09e48b4c53817c73d98b4ab22' );
define( 'TWILIO_TOKEN', 'f0cd2cdca23a9f16147e57e40c91ed6b' );
define( 'TWILIO_NUMBER', '+12089699709' );
//define('TWILIO_NUMBER', "+13476952092");
define( 'COUNTRY_CODE', '+84' );
define( 'SMS_TEMPLATE', "[CODE] __code__\nMã kích hoạt của bạn là __code__" );
//define( 'TWILIO_ACCOUNT', 'AC7985c82c260e3bfc636f717382039231' );
//define( 'TWILIO_TOKEN',   '03da49b8c9d91be710fdb474b4cd8f55' );
//define( 'TWILIO_NUMBER',  '+15162520708' );

/**
 * Features Plugin Information File
 */
class Plugin extends PluginBase
{	
    /**
	 * Returns information about this plugin.
	 *
	 * @return array
	 */
	public function pluginDetails() {
		return [
			'name' => 'Features',
			'description' => 'No description provided yet...',
			'author' => 'DLNLab',
			'icon' => 'icon-leaf'
		];
	}

	public function registerNavigation() {
		return [
			'features' => [
				'label' => 'Features',
				'url' => Backend::url('dlnlab/features/reward'),
				'icon' => 'icon-photo',
				'permissions' => ['dlnlab.features.*'],
				'order' => 500,
				'sideMenu' => [
					'reward' => [
						'label' => 'Reward',
						'icon' => 'icon-list-ul',
						'url' => Backend::url('dlnlab/features/reward'),
						'permissions' => ['dlnlab.features.reward'],
					],
					'money' => [
						'label' => 'Money',
						'icon' => 'icon-list-ul',
						'url' => Backend::url('dlnlab/features/money'),
						'permissions' => ['dlnlab.features.money'],
					]
				]
			]
		];
	}

	public function registerComponents() {
		return [
			'DLNLab\Money\Components\ActionRegisterReward' => 'ActionRegisterReward'
		];
	}

}
