<?php

namespace DLNLab\Money;

use Backend;
use Controller;
use Event;
use System\Classes\PluginBase;

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
			'name' => 'Money',
			'description' => 'No description provided yet...',
			'author' => 'DLNLab',
			'icon' => 'icon-leaf'
		];
	}

	public function registerNavigation() {
		return [
			'marketing' => [
				'label' => 'Marketing',
				'url' => Backend::url('dlnlab/money/referer'),
				'icon' => 'icon-photo',
				'permissions' => ['dlnlab.money.*'],
				'order' => 500,
				'sideMenu' => [
					'referer' => [
						'label' => 'Referer',
						'icon' => 'icon-list-ul',
						'url' => Backend::url('dlnlab/money/referer'),
						'permissions' => ['dlnlab.money.referer'],
					]
				]
			]
		];
	}

	public function registerComponents() {
		return [
			'DLNLab\Classified\Components\AdPost' => 'AdPost',
			'DLNLab\Classified\Components\AdPosts' => 'AdPosts'
		];
	}

}
