<?php namespace DLNLab\AloExrates;

use Backend;
use System\Classes\PluginBase;

require_once 'defines.php';

/**
 * AloExrates Plugin Information File
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
            'name'        => 'AloExrates',
            'description' => 'No description provided yet...',
            'author'      => 'DLNLab',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Function for register navigations.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'aloexrates' => [
                'label' => 'Tỷ giá',
                'url' => Backend::url('dlnlab/aloexrates/currency'),
                'icon' => 'icon-list',
                'permissions' => ['dlnlab.aloexrates.*'],
                'order' => 500,
                'sideMenu' => [
                    'currency' => [
                        'label' => 'Tỷ giá',
                        'icon' => 'icon-list',
                        'url' => Backend::url('dlnlab/aloexrates/currency'),
                    ],
                    'currency_daily' => [
                        'label' => 'Tỷ giá hàng ngày',
                        'icon' => 'icon-list',
                        'url' => Backend::url('dlnlab/aloexrates/currencydaily')
                    ],
                    'device' => [
                        'label' => 'Thiết bị',
                        'icon' => 'icon-list',
                        'url' => Backend::url('dlnlab/aloexrates/device')
                    ]
                ]
            ]
        ];
    }

}
