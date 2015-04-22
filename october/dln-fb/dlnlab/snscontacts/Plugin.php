<?php namespace DLNLab\SNSContacts;

use System\Classes\PluginBase;

require_once 'defines.php';

/**
 * SNSContacts Plugin Information File
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
            'name'        => 'SNSContacts',
            'description' => 'No description provided yet...',
            'author'      => 'DLNLab',
            'icon'        => 'icon-leaf'
        ];
    }

}
