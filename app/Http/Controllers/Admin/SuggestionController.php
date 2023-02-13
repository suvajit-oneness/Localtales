<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Contracts\PincodeContract;
use App\Models\HelpComment;
use App\Models\ActivityLogCsv;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PinCodeExport;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Session as FacadesSession;
class SuggestionController extends BaseController
{
    protected $PincodeRepository;

    /**
     * StateManagementController constructor.
     * @param PincodeRepository $StateRepository
     */

    public function __construct(PincodeContract $PincodeRepository)
    {
        $this->PincodeRepository = $PincodeRepository;
    }

    /**
     * List all the states
     */
    public function index(Request $request)
    {
       
        $this->setPageTitle('Comment', 'List of all Comment');
        $comment = HelpComment::latest('id','desc')->get();
        //dd($comment);
        return view('admin.suggestion.index', compact('comment'));
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetpin = $this->PincodeRepository->detailsPincode($id);
        $pin = $targetpin[0];

        $this->setPageTitle('Postcode', 'Postcode Details : ' . $pin->pin);
        return view('admin.pin.details', compact('pin'));
    }
    
    public function csv(Request $request)
    {
       
        $this->setPageTitle('CSV Activity Log', 'List of all CSV Activity');
        $csv = ActivityLogCsv::latest('id','desc')->get();
        //dd($comment);
        return view('admin.csv-activity.index', compact('csv'));
    }
    
}
