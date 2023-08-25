<?php

namespace Centerpoint\Reader\Repository\QueryGenerate;
use DB;
use Illuminate\Support\Collection;
use Centerpoint\Reader\Repository\BaseRepository;

class QueryGenerateRepository extends BaseRepository {

    public function model()
    {
        $database = DB::connection('databaseconnectionname');
        return $database;
    }

    public function selectStatementForJoinQuery()
    {
        $parentTableCols = new Collection($this->tableName()['selectStatementParentTable']);
        $joinTableCols = new Collection($this->tableName()['selectStatementJoinTable']);

        $mergedCollection = $parentTableCols->merge($joinTableCols);
        $mergedCollectionToArray = $mergedCollection->toArray();
        return $mergedCollectionToArray;
    }

    public function list()
    {
        switch ($this->tableName()['join'] == 'yes') {
            case 'yes':
                try {
                    $resultOfChildRepo = $this->model()
                                    ->table($this->tableName()['parent_table_name'])
                                    ->select($this->selectStatementForJoinQuery())
                                    ->join($this->tableName()['join_table_name'],$this->tableName()['parent_table_name'].'.'.$this->tableName()['parent_table_col'],'=',$this->tableName()['join_table_name'].'.'.$this->tableName()['join_table_col'])
                                    ->take($this->tableName()['take'])
                                    ->orderBy($this->tableName()['tableOrderBy'],$this->tableName()['tableOrderType'])
                                    ->get();
                } catch (\Throwable $th) {
                    echo $th->getMessage();
                }
                break;
            
            default:
                try {
                    $resultOfChildRepo = $this->model()
                                ->table($this->tableName()['tableName'])
                                ->select($this->tableName()['tableCols'])
                                ->take($this->tableName()['take'])
                                ->orderBy($this->tableName()['tableOrderBy'],$this->tableName()['tableOrderType'])
                                ->get();
                } catch (\Throwable $th) {
                    echo $th->getMessage();
                }
                break;
        }
        return $resultOfChildRepo;
    }

}