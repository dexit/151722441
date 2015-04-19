<?php

namespace DLNLab\FBNews;

use Backend;
use System\Classes\PluginBase;

require_once 'define.php';

//https://graph.facebook.com/822643817770854/picture?access_token=225132297553705|8f00d29717ee8c6a49cd25da80c5aad8&type=small
//DB::enableQueryLog();
//$queries = DB::getQueryLog();
//var_dump($queries);die();

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
                    'category' => [
                        'label' => 'Category',
                        'icon' => 'icon-list-ul',
                        'url' => Backend::url('dlnlab/fbnews/fbcategory'),
                        'permissions' => ['dlnlab.fbnews.fbcategory'],
                    ],
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

    public function register()
    {
        //$this->registerConsoleCommand('dlnlab.crawl', 'Plugin\Console\CrawlConsoleCommand');
    }

}
