<?php
namespace Centerpoint\Reader\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

Abstract class BaseRepository {

    abstract function model();

    public function tableProperties()
    {
        $file       = __DIR__ . '../../DbInfo/dbInfo.json';
        $jsonData   = file_get_contents($file);
        $data       = json_decode($jsonData, true); 

        if ($data) {
            $tableName                  =   $data['table_name'];
            $tableCols                  =   explode(', ', $data['table_col']);
            $tableOrderBy               =   $data['table_data_order_by'];
            $tableOrderType             =   $data['table_data_order_type'];
            $take                       =   $data['table_data_retrive_amount'];
            $join                       =   $data['join'];
            $parentTableCol             =   $data['parent_table_col'] ?? '';
            $joinTableName              =   $data['join_table_name'] ?? '';    
            $joinTableCol               =   $data['join_table_col'] ?? '';
            $joinTableColName           =   $data['join_table_col_name'] ?? '';
            $selectStatementParentTable =   $this->selectStatementParentTable($data['table_name'] ?? '', explode(', ', $data['table_col']) ?? '');
            $selectStatementJoinTable   =   $this->selectStatementJoinTable($data['join_table_name'] ?? '', explode(', ', $data['join_table_col_name'] ?? ''));

        } else {
            echo "Please define relation to get the data from the database.";
        }
        return [
            'tableName'                         =>  $tableName, 
            'tableCols'                         =>  $tableCols,
            'tableOrderBy'                      =>  $tableOrderBy,
            'tableOrderType'                    =>  $tableOrderType,
            'take'                              =>  $take,
            'join'                              =>  $join,
            'parentTableCol'                    => $parentTableCol,
            'joinTableName'                     =>  $joinTableName,
            'joinTableCol'                      => $joinTableCol,
            'joinTableColName'                  => $joinTableColName,
            'selectStatementParentTable'        =>   $selectStatementParentTable,
            'selectStatementJoinTable'          =>  $selectStatementJoinTable,

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
            $joinTableColms = explode(', ', $this->tableProperties()['joinTableColName']);
            $mergeColms = array_merge($parentTableColms,$joinTableColms);
            return $mergeColms;
        }else {
            $parentTableColms = $this->tableProperties()['tableCols'];
            return $parentTableColms;
        }
    }

}