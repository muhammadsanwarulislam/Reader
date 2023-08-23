<?php

namespace Centerpoint\Reader\Repository\Child;
use Centerpoint\Reader\Repository\BaseRepository;
use DB;
use Exception;

class ChildRepository extends BaseRepository {

    public function model()
    {
        $database = DB::connection('databaseconnectionname');
        return $database;
    }

    public function list()
    {
        // $file=__DIR__ . '/dbInfo.json';
        // $lines=file($file);
        // var_dump($lines[1]);
        // foreach( $lines as $line ){
        //     $json=json_decode( $line );
        //     printf('%s<hr />', $json );
        // }
        try {
            $resultOfChildRepo =$this->model()
                                ->table('audit_log')
                                ->select('audit_log.*','users.name','users.email','npf_domains.subdomain')
                                ->join('npfministry_common.users','audit_log.user_id','=','users.id')
                                ->join('npf_domains','audit_log.domain_id','=','npf_domains.id')
                                ->take(1000)
                                ->orderBy('audit_log.id','desc')
                                ->get();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return $resultOfChildRepo;
    }

}