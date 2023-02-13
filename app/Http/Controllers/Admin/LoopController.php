<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\LoopContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class LoopController extends BaseController
{
    /**
     * @var LoopContract
     */
    protected $loopRepository;


    /**
     * PageController constructor.
     * @param LoopContract $loopRepository
     */
    public function __construct(LoopContract $loopRepository){
        $this->loopRepository = $loopRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $loops = $this->loopRepository->listLoops();

        $this->setPageTitle('Local Loops', 'List of all loops');
        return view('admin.loop.index', compact('loops'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $loop = $this->loopRepository->deleteLoop($id);

        if (!$loop) {
            return $this->responseRedirectBack('Error occurred while deleting loop.', 'error', true, true);
        }
        return $this->responseRedirect('admin.loop.index', 'Loop has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $loop = $this->loopRepository->updateLoopStatus($params);

        if ($loop) {
            return response()->json(array('message'=>'Loop status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $loops = $this->loopRepository->detailsLoop($id);
        $loop = $loops[0];
        
        $this->setPageTitle('Loop', 'Loop Details : '.$loop->title);
        return view('admin.loop.details', compact('loop'));
    }
}
