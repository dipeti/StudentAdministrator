<?php

namespace AppBundle\Composer;

use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as BaseScriptHandler;
use Composer\Script\Event;

class ScriptHandler extends BaseScriptHandler
{
    /**
     * Call the app:install:assets command of the AppBundle.
     *
     * @param $event Event instance
     */
    public static function installAssets(Event $event)
    {
        $options = static::getOptions($event);
        $consoleDir = static::getConsoleDir($event, 'app install assets');

        if (null === $consoleDir)
        {
            return;
        }

        $webDir = $options['symfony-web-dir'];

        $symlink = '';
        if ('symlink' == $options['symfony-assets-install'])
        {
            $symlink = '--symlink ';
        }
        elseif ('relative' == $options['symfony-assets-install'])
        {
            $symlink = '--symlink --relative ';
        }

        static::executeCommand($event, $consoleDir, 'app:assets:install '.$symlink.escapeshellarg($webDir), $options['process-timeout']);
    }

}
