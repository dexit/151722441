<?php namespace DLNLab\Classified;

use Backend;
use Controller;
use Event;
use System\Classes\PluginBase;

/**
 * Classified Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
        'name'        => 'Classified',
        'description' => 'No description provided yet...',
        'author'      => 'DLNLab',
        'icon'        => 'icon-leaf'
            ];
    }

    public function registerNavigation() {
        return [
        'classified' => [
        'label'          => 'dlnlab.classified::lang.ads.menu_label',
        'url'         => Backend::url('dlnlab/classified/ads'),
        'icon'          => 'icon-photo',
        'permissions' => ['dlnlab.classified.*'],
        'order'       => 500,

        'sideMenu' => [
        'ads' => [
        'label'       => 'dlnlab.classified::lang.ads.menu_label',
        'icon'        => 'icon-copy',
        'url'         => Backend::url('dlnlab/classified/ads'),
        'permissions' => ['dlnlab.classified.access_ads'],
        ],
        'ads_categories' => [
        'label'       => 'dlnlab.classified::lang.ads.categories',
        'icon'        => 'icon-list-ul',
        'url'         => Backend::url('dlnlab/classified/adscategories'),
        'permissions' => ['rainlab.blog.access_ads_categories'],
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
