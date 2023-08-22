<?php

namespace Centerpoint\Reader;

class Setup
{
    public static function run()
    {
        $input = readline("Enter some input: ");
        echo "You entered: $input\n";
    }
}


