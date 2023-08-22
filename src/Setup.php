<?php

namespace Centerpoint\Reader;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class Setup
{
    public static function run(Event $event)
    {
        // $input = readline("Enter some input: ");
        // echo "You entered: $input\n";
        $composer = $event->getComposer();
        var_dump($composer);
        die();
    }
}


