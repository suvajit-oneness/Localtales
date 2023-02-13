<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Contracts\LoopContract;
use App\Contracts\EventContract;
use App\Contracts\DealContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Auth;

class LoopController extends BaseController
{
	/**
     * @var LoopContract
     */
    protected $loopRepository;
    /**
     * @var EventContract
     */
    protected $eventRepository;
    /**
     * @var DealContract
     */
    protected $dealRepository;


    /**
     * PageController constructor.
     * @param LoopContract $loopRepository
     * @param EventContract $eventRepository
     * @param DealContract $dealRepository
     */
    public function __construct(LoopContract $loopRepository, EventContract $eventRepository, DealContract $dealRepository){
        $this->loopRepository = $loopRepository;
        $this->eventRepository = $eventRepository;
        $this->dealRepository = $dealRepository;
    }

    public function index(){
    	$loops = $this->loopRepository->getLoops();

        $pinCode = '3000';

        $deals = $this->dealRepository->getTrendingDealsByPinCode($pinCode);
        $events = $this->eventRepository->getEventsByPinCode($pinCode);

    	$this->setPageTitle('Local Loops', 'List of all discussions');
        return view('site.loop.index', compact('loops','deals','events'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createComment(Request $request){
        $this->validate($request, [
            'loop_id'      =>  'required',
            'comment'     =>  'required',
        ]);

        $params = $request->except('_token');
        $params['user_id'] = Auth::user()->id;
        
        $comment = $this->loopRepository->createComment($params);

        if (!$comment) {
            return $this->responseRedirectBack('Error occurred while adding comment.', 'error', true, true);
        }

        return $this->responseRedirectBack( 'Comment has been added successfully' ,'success',false, false);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loopLike($id){
        $user_id = Auth::user()->id;
        
        $comment = $this->loopRepository->likeLoop($user_id,$id);

        return $this->responseRedirectBack( 'Loop status has been updated successfully' ,'success',false, false);
    }
}