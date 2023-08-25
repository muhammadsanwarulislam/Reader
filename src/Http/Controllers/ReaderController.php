<?php
namespace Centerpoint\Reader\Http\Controllers;

use App\Http\Controllers\Controller;
use Centerpoint\Reader\Repository\QueryGenerate\QueryGenerateRepository;

class ReaderController extends Controller {
    protected $queryGenerateRepository;

    function __construct(QueryGenerateRepository $queryGenerateRepository)
    {
        $this->queryGenerateRepository   =  $queryGenerateRepository;
    }
    
    public function index()
    {
        $colms      = $this->queryGenerateRepository->tableName()['tableCols'];
        $results    = $this->queryGenerateRepository->list();
        
        return view('reader::list',compact('colms','results'));
    }
}