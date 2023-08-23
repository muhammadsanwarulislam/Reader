<?php

namespace Centerpoint\Reader;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class Setup
{
    public static function postUpdate(Event $event)
    {
        $composer = $event->getComposer();
        var_dump('postUpdate',$composer);
    }

    public static function postAutoloadDump(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir . '/autoload.php';
    }

    public static function postPackageInstall(PackageEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
        var_dump('postPackageInstall',$installedPackage);
    }

    public static function warmCache(Event $event)
    {
        var_dump('warmCache',$event);
    }
}


