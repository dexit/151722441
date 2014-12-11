<?php namespace DLNLab\Features;

use Backend;
use Controller;
use Event;
use System\Classes\PluginBase;

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
