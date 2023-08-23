<?php

namespace Centerpoint\Reader;


class Setup
{
    public static function dbQuerySetup()
    {
        $arr = [];
        $table_name = readline('Enter table name: ');
        readline_read_history($arr['table_name']=$table_name);

        $table_col = readline('Enter table col: ');
        readline_read_history($arr['table_col']=$table_col);

        $fp = fopen('src/Repositories/dbInfo.json', 'w');
        fwrite($fp, json_encode($arr, JSON_PRETTY_PRINT));   
        fclose($fp);
    }
}


