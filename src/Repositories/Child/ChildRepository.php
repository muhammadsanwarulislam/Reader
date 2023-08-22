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

    public function auditList()
    {
        try {
            $audit_logs =$this->model()
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
        return $audit_logs;
    }

    public function contentTypeTables()
    {
        $prefix = DB::getTablePrefix();
        $tables = DB::table('information_schema.tables')
                    ->select('TABLE_NAME')
                    ->where('TABLE_SCHEMA', config('database.connections.eductionCluster.database'))
                    ->where('TABLE_NAME', 'like', $prefix . 'npf_%')
                    ->where('TABLE_NAME', 'not like', '%_version')
                    ->where(function ($query) use ($prefix) {
                        $query->whereIn('TABLE_NAME', [$prefix . 'npf_blocks', $prefix . 'npf_webforms_data'])
                            ->orWhere('TABLE_NAME', 'like', $prefix . 'npf_content_%');
                    })
                    ->get();
        return $tables;
    }

    public function contentRetriveQery($TABLE_NAME)
    {
       return $this->model()
                ->table($TABLE_NAME)
                ->select($TABLE_NAME.".*")
                // ->whereBetween('created',['2023-07-01','2023-07-31'])
                ->orderBy('created','desc')
                ->count();
    }

    public function contentList()
    {
        $result = $this->contentTypeTables();
        $result = json_decode(json_encode($result),true);
        $data = [];
        foreach($result as $re) {
            switch ($re['TABLE_NAME']) {
                case 'npf_blocks':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_ads':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_advertisement':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_album':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_allnotes':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_annual_reports':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_bbs_officials':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_biography':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_birsrestha':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_boi_law':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_branch':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_cabinet_photogallery':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_cabinet_secretary':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_calendar_event':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_central_eservices':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_charter_of_duties':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                case 'npf_content_charter_of_duties':
                    $data[$re['TABLE_NAME']] = $this->contentRetriveQery($re['TABLE_NAME']);
                    break;
                default:
                    echo $re['TABLE_NAME'];
                    break;
                    
            }
        }  
        return $data;
    }

    public function portalUser($domain_id)
    {
        $result = $this->model()
                ->table('npf_domains')
                ->select('npf_domains.id', 'npf_domains.subdomain','npf_domains.sitename_bn','npf_domains.sitename_en','npf_domains.last_content_updated','users.name','users.email','users.designation')
                ->where('npf_domains.id',$domain_id)
                ->join('npfministry_common.users','users.domain_id','=','npf_domains.id')
                ->get();
        return $result;
    }
}