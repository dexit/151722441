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
                'label' => 'Exrates',
                'url' => Backend::url('dlnlab/aloexrates/currencies')
            ]
        ];
    }

}
