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
        $parentTableCols = new Collection($this->tableProperties()['selectStatementParentTable']);
        $joinTableCols = new Collection($this->tableProperties()['selectStatementJoinTable']);

        $mergedCollection = $parentTableCols->merge($joinTableCols);
        $mergedCollectionToArray = $mergedCollection->toArray();
        return $mergedCollectionToArray;
    }

    public function list()
    {
        switch ($this->tableProperties()['join'] == 'yes') {
            case 'yes':
                try {
                    $resultOfChildRepo = $this->model()
                                    ->table($this->tableProperties()['parent_table_name'])
                                    ->select($this->selectStatementForJoinQuery())
                                    ->join($this->tableProperties()['join_table_name'],$this->tableProperties()['parent_table_name'].'.'.$this->tableProperties()['parent_table_col'],'=',$this->tableProperties()['join_table_name'].'.'.$this->tableProperties()['join_table_col'])
                                    ->take($this->tableProperties()['take'])
                                    ->orderBy($this->tableProperties()['tableOrderBy'],$this->tableProperties()['tableOrderType'])
                                    ->get();
                } catch (\Throwable $th) {
                    echo $th->getMessage();
                }
                break;
            
            default:
                try {
                    $resultOfChildRepo = $this->model()
                                ->table($this->tableProperties()['tableName'])
                                ->select($this->tableProperties()['tableCols'])
                                ->take($this->tableProperties()['take'])
                                ->orderBy($this->tableProperties()['tableOrderBy'],$this->tableProperties()['tableOrderType'])
                                ->get();
                } catch (\Throwable $th) {
                    echo $th->getMessage();
                }
                break;
        }
        return $resultOfChildRepo;
    }

}