<?php

namespace DLNLab\FBNews;

use Backend;
use System\Classes\PluginBase;

define('DLN_LIMIT', 10);
define('FB_APP_ID', '225132297553705');
define('FB_APP_SECRET', '8f00d29717ee8c6a49cd25da80c5aad8');

/**
 * FBNews Plugin Information File
 */
class Plugin extends PluginBase {

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name' => 'FBNews',
            'description' => 'No description provided yet...',
            'author' => 'DLNLab',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerNavigation() {
        return [
            'fbnews' => [
                'label' => 'FB News',
                'url' => Backend::url('dlnlab/fbnews/fbpage'),
                'icon' => 'icon-photo',
                'permissions' => ['dlnlab.fbnews.*'],
                'order' => 500,
                'sideMenu' => [
                    'page' => [
                        'label' => 'Page',
                        'icon' => 'icon-list-ul',
                        'url' => Backend::url('dlnlab/fbnews/fbpage'),
                        'permissions' => ['dlnlab.fbnews.fbpage'],
                    ],
                    'feed' => [
                        'label' => 'Feed',
                        'icon' => 'icon-list-ul',
                        'url' => Backend::url('dlnlab/fbnews/fbfeed'),
                        'permissions' => ['dlnlab.fbnews.fbfeed'],
                    ]
                ]
            ]
        ];
    }

}
