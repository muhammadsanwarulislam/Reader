<?php
namespace Centerpoint\Reader\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

Abstract class BaseRepository {

    abstract function model();

    public function tableProperties()
    {
        $file       = __DIR__ . '/dbInfo.json';
        $jsonData   = file_get_contents($file);
        $data       = json_decode($jsonData, true); 

        if ($data) {
            $tableName                  =   $data['table_name'];
            $tableCols                  =   explode(', ', $data['table_col']);
            $tableOrderBy               =   $data['table_data_order_by'];
            $tableOrderType             =   $data['table_data_order_type'];
            $take                       =   $data['table_data_retrive_amount'];
            $join                       =   $data['join'];
            $parent_table_name          =   $data['parent_table_name'] ?? '';
            $parent_table_col           =   $data['parent_table_col'] ?? '';
            $join_table_name            =   $data['join_table_name'] ?? '';    
            $join_table_col             =   $data['join_table_col'] ?? '';
            $join_table_col_name        =   $data['join_table_col_name'] ?? '';
            $selectStatementParentTable =   $this->selectStatementParentTable($data['parent_table_name'] ?? '', explode(', ', $data['table_col']) ?? '');
            $selectStatementJoinTable   =   $this->selectStatementJoinTable($data['join_table_name'] ?? '', explode(', ', $data['join_table_col_name'] ?? ''));

        } else {
            echo "Invalid JSON data.";
        }
        return [
            'tableName'             =>  $tableName, 
            'tableCols'             =>  $tableCols,
            'tableOrderBy'          =>  $tableOrderBy,
            'tableOrderType'        =>  $tableOrderType,
            'take'                  =>  $take,
            'join'                  =>  $join,
            'parent_table_name'     => $parent_table_name,
            'parent_table_col'      => $parent_table_col,
            'join_table_name'       =>  $join_table_name,
            'join_table_col'        => $join_table_col,
            'join_table_col_name'   => $join_table_col_name,
            'selectStatementParentTable'   =>   $selectStatementParentTable,
            'selectStatementJoinTable'      =>  $selectStatementJoinTable,

        ];
    }

    private function selectStatementParentTable($parentTable, $parent_table_cols)
    {
        $prefixedTheParentTableName = array_map(function ($column) use ($parentTable) {
            return "\"$parentTable.$column\"";
        }, $parent_table_cols);

        $removeDoubleQuotation = array_map(function ($item) {
            return str_replace('"', '', $item);
        }, $prefixedTheParentTableName);

        return $removeDoubleQuotation;
    }

    private function selectStatementJoinTable($joinTable, $join_table_cols)
    {
        $prefixedTheJoinTableName = array_map(function ($column) use ($joinTable) {
            return "\"$joinTable.$column\"";
        }, $join_table_cols);

        $removeDoubleQuotation = array_map(function ($item) {
            return str_replace('"', '', $item);
        }, $prefixedTheJoinTableName);

        return $removeDoubleQuotation;
    }

    public function mergeColms()
    {
        if($this->tableProperties()['join'] == 'yes') {
            $parentTableColms = $this->tableProperties()['tableCols'];
            $joinTableColms = explode(', ', $this->tableProperties()['join_table_col_name']);
            $mergeColms = array_merge($parentTableColms,$joinTableColms);
            return $mergeColms;
        }else {
            $parentTableColms = $this->tableProperties()['tableCols'];
            return $parentTableColms;
        }
    }

}