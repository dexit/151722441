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
define('FB_GRAPH', 'https://graph.facebook.com/v2.2/');
define('FB_APP_ID', '225132297553705');
define('FB_APP_SECRET', '8f00d29717ee8c6a49cd25da80c5aad8');
define('PAGE_ID', '408730579166315');
define('PAGE_TOKEN', 'CAADMwbKfhykBAM6mSY3gAdUfor2wpkDnvnPbRDC6V2rqZCQpy7965uby5PhR8zT2wEFwm0v12t2TDdQ9wsFscp7AbPayML68B2pRp7idaUxPZA2fuOTLSS0OOgu7BnWyK2tWcVi7ZBxHhZAy8InVVe519JsZAqZC85fx8BYISJSGWUA2iSKyRnQMhyj7mwu7EZD');
define('BIT_TOKEN', '9e016bcaeee8f29bae802366a3f2eaa32b4937fc');
define('LIMIT_COMMENT_COUNT', 10);
define('FB_COMMENT_PATTERN', 'Xem thêm: ');
define('TAG', '#vivufb_');
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
