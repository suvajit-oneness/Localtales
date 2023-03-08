<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Contracts\EventContract;
use App\Contracts\CategoryContract;
use App\Contracts\EventformatContract;
use App\Contracts\LanguageContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Event;
use Auth;
use DB;
class EventController extends BaseController
{
    /**
     * @var EventContract
     */
    protected $eventRepository;
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;
    /**
     * @var EventformatContract
     */
    protected $eventformatRepository;
    /**
     * @var LanguageContract
     */
    protected $languageRepository;


    /**
     * EventController constructor.
     * @param EventContract $eventRepository
     * @param CategoryContract $categoryRepository
     * @param EventformatContract $eventformatRepository
     * @param LanguageContract $languageRepository
     */
    public function __construct(EventContract $eventRepository,CategoryContract $categoryRepository,EventformatContract $eventformatRepository,LanguageContract $languageRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->categoryRepository = $categoryRepository;
        $this->eventformatRepository = $eventformatRepository;
        $this->languageRepository = $languageRepository;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (isset($request->code) || isset($request->keyword) || isset($request->name)) {
            // dd($request->all());
            $category = $request->directory_category;
            $code = $request->code;
            $keyword = $request->keyword;
            $type = $request->type;
            $name = $request->name;

            if (!empty($keyword)) {
                //$keywordQuery = "AND address like '%$keyword' ";
                $events = DB::table('events')->whereRaw("address like '%$keyword'")->where('status', 1)->paginate(18)->appends(request()->query());
            }
            if (!empty($name)) {
                $events = DB::table('events')->whereRaw("title like '%$name%'")->where('status', 1)->paginate(18)->appends(request()->query());
            }

            if (!empty($code)) {
                // if primary category
                if ($type == "primary") {
                    $keywordQuery = "AND title like '%$name%' ";
                    $events = DB::table('events')->whereRaw("address like '%$keyword' $keywordQuery and
                    ( category_id like '$request->code%' or category_id like '%,$request->code%' )")->where('status', 1)->paginate(18)->appends(request()->query());
                } elseif ($type == "secondary") {
                    $keywordQuery = "AND title like '%$name%' ";
                    $events = DB::table('events')->whereRaw("address like '%$keyword' $keywordQuery and
                    ( category_id like '$request->code%' or category_id like '%,$request->code%' )")->where('status', 1)->paginate(18)->appends(request()->query());
                }
            }
        } else {
              // $directoryList = Directory::paginate(18)->appends(request()->query());
             
             $events = Event::where('status', 1)->paginate(18)->appends(request()->query());
            }
        $categories = $this->categoryRepository->listCategories();
        $displayRelated = array();
        $pincode = (int) \Str::substr($request->keyword, -5, 5);
        $pin0 = $pincode;
        $pin1 = $pincode + 1;

        $pin2 = $pincode - 1;

        $pin3 = $pincode + 2;

        $pin4 = $pincode - 2;

        $pin5 = $pincode + 3;

        $pin6 = $pincode - 3;

        $pin7 = $pincode + 4;

        $pin8 = $pincode - 4;

        $pin9 = $pincode + 5;

        $pin10 = $pincode - 5;

        
        if(count($displayRelated)<8){

            $data0 = DB::select("select * from events where pin like '%$pin0%'");
             //dd($pin0, $data0);
            foreach($data0 as $d){

                array_push($displayRelated,$d);

            }

        }
        $data1 = DB::select("select * from events where pin like '%$pin1%'");

        $data2 = DB::select("select * from events where pin like '%$pin2%'");
         //dd($pin1, $pin2, $data1, $data2);
        foreach($data1 as $d){

            array_push($displayRelated,$d);

        }
        foreach($data2 as $d){

            array_push($displayRelated,$d);

        }
        if(count($displayRelated)<8){

            $data3 = DB::select("select * from events where pin like '%$pin3%' ");

            $data4 = DB::select("select * from events where pin like '%$pin4%' ");
            foreach($data3 as $d){

                array_push($displayRelated,$d);

            }
            foreach($data4 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data5 = DB::select("select * from events where pin like '%$pin5%' ");

            $data6 = DB::select("select * from events where pin like '%$pin6%' ");
            foreach($data5 as $d){

                array_push($displayRelated,$d);

            }
            foreach($data6 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data7 = DB::select("select * from events where pin like '%$pin7%' ");

            $data8 = DB::select("select * from events where pin like '%$pin8%' ");
            foreach($data7 as $d){

                array_push($displayRelated,$d);

            }

            foreach($data8 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data9 = DB::select("select * from events where pin like '%$pin9%' ");

            $data10 = DB::select("select * from events where pin like '%$pin10%' ");

            foreach($data9 as $d){

                array_push($displayRelated,$d);

            }

            foreach($data10 as $d){

                array_push($displayRelated,$d);

            }

        }
        
        $resp = [];

        foreach($displayRelated as $event) {
         //dd($displayRelated);
            // category
            if (!empty($event->category_id)) {
                $catArr = explode(',', $event->category_id);

                $categoryArr = [];

                foreach($catArr as $catKey => $catVal) {
                    $catDetails = \App\Models\DirectoryCategory::select('id', 'title', 'child_category', 'child_category_slug')->where('id', $catVal)->first();
                    if ($catDetails) {
                        if(!in_array_r($catDetails->child_category, $categoryArr)) {
                            $categoryArr[] = [
                                'id' => $catDetails->id,
                                'title' => $catDetails->title,
                                'child_category' => $catDetails->child_category,
                                'child_category_slug' => $catDetails->child_category_slug
                            ];
                        }
                    }
                }
            } else {
                $categoryArr = '';
            }

            $resp[] = [

                'id' => $event->id,

                'name' => $event->title,

                'slug' => $event->slug,

                'image' => $event->image,

                'short_description' => $event->short_description,

                'start_date' => date('j M, Y', strtotime($event->start_date)),

                'end_date' => date('j M, Y', strtotime($event->end_date)),

                'start_time' => date('g:i A', strtotime($event->start_time)),

                'end_time' => date('g:i A', strtotime($event->end_time)),

                'contact_email' => $event->contact_email,

                'category' => $categoryArr,

            ];

        }
       //dd($resp);
        $this->setPageTitle('Events', 'List of all events');
        return view('site.event.index', compact('events','categories','request','resp'));
    }

     /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($slug)
    {
        $eventData=Event::where('slug',$slug)->get();
        $events = $this->eventRepository->detailsEvent($eventData[0]->id);
        $event = $events[0];

        $eventSaved = 0;

        if(Auth::guard('user')->check()){
            $user_id = Auth::guard('user')->user()->id;

            $eventSavedResult = $this->eventRepository->checkUserEvents($eventData[0]->id,$user_id);

            if(count($eventSavedResult)>0){
                $eventSaved = 1;
            }else{
                $eventSaved = 0;
            }
        }

        $this->setPageTitle($event->title, 'Events Details : '.$event->title);
        return view('site.event.details', compact('event','eventSaved'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function saveUserEvent($id){
        $user_id = Auth::user()->id;

        $this->eventRepository->saveUserEvent($id,$user_id);

        return $this->responseRedirectBack( 'You have saved this event' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteUserEvent($id){
        $user_id = Auth::user()->id;

        $this->eventRepository->deleteUserEvent($id,$user_id);

        return $this->responseRedirectBack( 'You have removed this event from your list' ,'success',false, false);
    }

    //related event
    public function relatedEvent(Request $request)
    {
        $displayRelated = array();
        $pincode = (int) \Str::substr($request->keyword, -5, 5);
        $pin0 = $pincode;

        $pin1 = $pincode + 1;

        $pin2 = $pincode - 1;

        $pin3 = $pincode + 2;

        $pin4 = $pincode - 2;

        $pin5 = $pincode + 3;

        $pin6 = $pincode - 3;

        $pin7 = $pincode + 4;

        $pin8 = $pincode - 4;

        $pin9 = $pincode + 5;

        $pin10 = $pincode - 5;

        $pin11 = $pincode + 6;

        $pin12 = $pincode - 6;



        $pin13 = $pincode + 7;

        $pin14 = $pincode - 7;

        $pin15 = $pincode + 8;

        $pin16 = $pincode - 8;

        $pin17 = $pincode + 9;

        $pin18 = $pincode - 9;

        $pin19 = $pincode + 10;

        $pin20 = $pincode - 10;
        $cat1 = $cat[0];
        if(count($displayRelated)<8){

            $data0 = DB::select("select * from events where pin like '%, ".$pin0."'");
            // dd($pin0, $cat1, $request->id, $data0);
            foreach($data0 as $d){

                array_push($displayRelated,$d);

            }

        }
        $data1 = DB::select("select * from events where pin like '%, ".$pin1."'");

        $data2 = DB::select("select * from events where pin like '%, ".$pin2."'");
        // dd($pin1, $pin2, $data1, $data2);
        foreach($data1 as $d){

            array_push($displayRelated,$d);

        }
        foreach($data2 as $d){

            array_push($displayRelated,$d);

        }
        if(count($displayRelated)<8){

            $data3 = DB::select("select * from events where pin like '%, ".$pin3."' ");

            $data4 = DB::select("select * from events where pin like '%, ".$pin4."' ");
            foreach($data3 as $d){

                array_push($displayRelated,$d);

            }
            foreach($data4 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data5 = DB::select("select * from events where pin like '%, ".$pin5."' ");

            $data6 = DB::select("select * from events where pin like '%, ".$pin6."' ");
            foreach($data5 as $d){

                array_push($displayRelated,$d);

            }
            foreach($data6 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data7 = DB::select("select * from events where pin like '%, ".$pin7."' ");

            $data8 = DB::select("select * from events where pin like '%, ".$pin8."' ");
            foreach($data7 as $d){

                array_push($displayRelated,$d);

            }

            foreach($data8 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data9 = DB::select("select * from events where pin like '%, ".$pin9."' ");

            $data10 = DB::select("select * from events where pin like '%, ".$pin10."' ");

            foreach($data9 as $d){

                array_push($displayRelated,$d);

            }

            foreach($data10 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data11 = DB::select("select * from events where pin like '%, ".$pin11."' ");

            $data12 = DB::select("select * from events where pin like '%, ".$pin12."' ");

            foreach($data11 as $d){

                array_push($displayRelated,$d);

            }

            foreach($data12 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data13 = DB::select("select * from events where pin like '%, ".$pin13."' ");

            $data14 = DB::select("select * from events where pin like '%, ".$pin14."' ");
            foreach($data13 as $d){

                array_push($displayRelated,$d);

            }
            foreach($data14 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data15 = DB::select("select * from events where pin like '%, ".$pin15."' ");

            $data16 = DB::select("select * from events where pin like '%, ".$pin16."' ");

            foreach($data15 as $d){

                array_push($displayRelated,$d);

            }
            foreach($data16 as $d){

                array_push($displayRelated,$d);

            }

        }

        if(count($displayRelated)<8){

            $data17 = DB::select("select * from events where pin like '%, ".$pin17."' ");

            $data18 = DB::select("select * from events where pin like '%, ".$pin18."' ");
            foreach($data17 as $d){

                array_push($displayRelated,$d);

            }
            foreach($data18 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data19 = DB::select("select * from events where pin like '%, ".$pin19."' ");

            $data = DB::select("select * from events where pin like '%, ".$pin20."' ");



            foreach($data19 as $d){

                array_push($displayRelated,$d);

            }
            foreach($data as $d){

                array_push($displayRelated,$d);

            }

        }
        $resp = [];

        foreach($displayRelated as $event) {

            // category
            if (!empty($event->category_id)) {
                $catArr = explode(',', $cat);

                $categoryArr = [];

                foreach($catArr as $catKey => $catVal) {
                    $catDetails = \App\Models\DirectoryCategory::select('id', 'title', 'child_category', 'child_category_slug')->where('id', $catVal)->first();
                    if ($catDetails) {
                        if(!in_array_r($catDetails->child_category, $categoryArr)) {
                            $categoryArr[] = [
                                'id' => $catDetails->id,
                                'title' => $catDetails->title,
                                'child_category' => $catDetails->child_category,
                                'child_category_slug' => $catDetails->child_category_slug
                            ];
                        }
                    }
                }
            } else {
                $categoryArr = '';
            }

            $resp[] = [

                'id' => $event->id,

                'name' => $event->title,

                'slug' => $event->slug,

                'image' => $event->image,

                'short_description' => $event->short_description,

                'start_date' => date('j M, Y', strtotime($event->start_date)),

                'end_date' => date('j M, Y', strtotime($event->end_date)),

                'start_time' => date('g:i A', strtotime($event->start_time)),

                'end_time' => date('g:i A', strtotime($event->end_time)),

                'contact_email' => $event->contact_email,

                'category' => $categoryArr,

            ];

        }
       //dd($resp);
        return response()->json(['error' => false, 'resp' => $resp]);

    }
}
