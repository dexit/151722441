<?php

namespace DLNLab\FBNews;

use Backend;
use System\Classes\PluginBase;

define('DLN_TOKEN', 'iammaster');
define('DLN_LIMIT', 20);
define('DLN_LIMIT_WEEK', 1);
define('DLN_CACHE_MINUTE', 2);
define('DLN_CACHE_LONG_MINUTE', 180);
define('DLN_CACHE_CATEGORY', 240);
define('DLN_CACHE_PAGE', 120);
define('DLN_CACHE_SHORT_MINUTE', 60);
define('FB_APP_ID', '225132297553705');
define('FB_APP_SECRET', '8f00d29717ee8c6a49cd25da80c5aad8');
define('PAGE_TOKEN', 'CAADMwbKfhykBAPcd4eSXIGVkz8ijJ0aRZBQS0NTvkZBQaY8Lszy96mE3Pdhqa515AK1sJnjtJGAE3IpB1szH1Xr0ZAzsUK6wHUO3m9AW00yZAaDmoFlB1XaYIkOtZB7X6fZC9LJCEqh051KdD9KZCfTmESHv5IbFERJtsR3vIHijyZBLvoGYlauDs5mkopVhW42ZAolLOcMxyg0aiaAA50UXFTahclOWMrlUZD');
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
        $this->registerConsoleCommand('dlnlab.crawl', 'Plugin\Console\CrawlConsoleCommand');
    }

}
