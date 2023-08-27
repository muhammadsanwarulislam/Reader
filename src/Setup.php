<?php

namespace Centerpoint\Reader;

use DB;

class Setup
{
    public static function dbQuerySetup()
    {
        $arr = [];
        $table_name = readline("What's the table name(like users): ");
        readline_read_history($arr['table_name']=$table_name);

        $table_col = readline("What's the table columns(like id, name, email): ");
        readline_read_history($arr['table_col']=$table_col);

        $table_data_order_by = readline("What's will the 'orderBy' table column(like id): ");
        readline_read_history($arr['table_data_order_by']=$table_data_order_by);

        $table_data_order_type = readline("What's will be the 'oderBy' type(like desc or asc): ");
        readline_read_history($arr['table_data_order_type']=$table_data_order_type);

        $table_data_retrive_amount = readline("How many data you want to retrive(like 100): ");
        readline_read_history($arr['table_data_retrive_amount']=$table_data_retrive_amount);

        $join = readline("Do you want joining(like yes or no): ");
        readline_read_history($arr['join']=$join);

        if($join == 'yes')
        {
            $parent_table_name = readline("Enter parent table name(like users): ");
            readline_read_history($arr['parent_table_name']=$parent_table_name);

            $parent_table_col = readline("Enter table col name(like id from user table) which will be the PRIMARY KEY: ");
            readline_read_history($arr['parent_table_col']=$parent_table_col);

            $join_table_name = readline("What's the joining table name(like domain): ");
            readline_read_history($arr['join_table_name']=$join_table_name);

            $join_table_col = readline("What's joining table col name(like domain_id) which will be the FOREIGN KEY: ");
            readline_read_history($arr['join_table_col']=$join_table_col);

            $join_table_col_name = readline("What's your excepted col name(like subdomain) that you retrive from the joining table: ");
            readline_read_history($arr['join_table_col_name']=$join_table_col_name);
        }

        $fp = fopen('src/Repositories/dbInfo.json', 'w');
        fwrite($fp, json_encode($arr, JSON_PRETTY_PRINT));   
        fclose($fp);
    }
}


