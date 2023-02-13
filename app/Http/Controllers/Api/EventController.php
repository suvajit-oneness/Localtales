<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\EventContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Auth;

class EventController extends BaseController
{
    /**
     * @var EventContract
     */
    protected $eventRepository;


    /**
     * EventController constructor.
     * @param EventContract $eventRepository
     */
    public function __construct(EventContract $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * This method is for getting events pin code wise
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3000';
        $events = $this->eventRepository->getEventsByPinCode($pinCode);

        return response()->json(compact('events'));
    }

    /**
     * This method is for getting deal details
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function details($id){
        $events = $this->eventRepository->detailsEvent($id);
        $event = $events[0];

        $related_events = $this->eventRepository->getRelatedEvents($event->pin,$id);

        return response()->json(compact('events','related_events'));
    }

    /**
     * This method is to filter deal data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request){
        $pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3000';
        $categoryId = (isset($request->category_id) && $request->category_id!='')?$request->category_id:'';
        $keyword = (isset($request->keyword) && $request->keyword!='')?$request->keyword:'';

        $events = $this->eventRepository->searchEventsData($pinCode,$categoryId,$keyword);
        
        return response()->json(compact('events'));
    }

    /**
     * This method is to get category wise events data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryWiseDeals(Request $request){
        $pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3000';
        $categoryId = (isset($request->category_id) && $request->category_id!='')?$request->category_id:'';

        $events = $this->eventRepository->getEventsByCategory($pinCode,$categoryId);
        
        return response()->json(compact('events'));
    }

    /**
     * This method is to save user event
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveUserEvent(Request $request){
        $event_id = $request->event_id;
        $user_id = $request->user_id;

        $this->eventRepository->saveUserEvent($event_id,$user_id);

        $data['message'] = "You have saved this event";

        return response()->json(compact('data'));
    }

    /**
     * This method is to delete user event
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserEvent(Request $request){
        $event_id = $request->event_id;
        $user_id = $request->user_id;

        $this->eventRepository->deleteUserEvent($event_id,$user_id);

        $data['message'] = "You have removed this event from your list";

        return response()->json(compact('data'));
    }

    /**
     * This method is to check user event exists
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUserEvents(Request $request){
        $event_id = $request->event_id;
        $user_id = $request->user_id;

        $userEvents = $this->eventRepository->checkUserEvents($event_id,$user_id);

        return response()->json(compact('userEvents'));
    }
}