<?php
namespace Centerpoint\Reader\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Centerpoint\Reader\Repository\Child\ChildRepository;

class ReaderController extends Controller {
    protected $childRepository;

    function __construct(ChildRepository $childRepository)
    {
        $this->childRepository   =  $childRepository;
    }
    
    public function index()
    {
        $results = $this->childRepository->list();
        return view('reader::list',compact('results'));
    }
}