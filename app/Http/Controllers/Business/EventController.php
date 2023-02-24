<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Contracts\EventContract;
use App\Contracts\CategoryContract;
use App\Contracts\BussinessLeadContract;
use App\Contracts\EventformatContract;
use App\Contracts\LanguageContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Event;
use App\Models\State;
use DB;
use Auth;

class EventController extends BaseController
{
    /**
     * @var EventContract
     */
    protected $eventRepository;
    /**
     * @var CategoryContract
     */
    protected $CategoryRepository;
    /**
     * @var BussinessLeadContract
     */
    protected $BusinessLeadRepository;
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
     * @param BussinessLeadContract $BusinessLeadRepository
     * @param DirectoryCategoryContract $DirectoryCategoryRepository
     * @param EventformatContract $eventformatRepository
     * @param LanguageContract $languageRepository
     */
    public function __construct(EventContract $eventRepository,CategoryContract $CategoryRepository,BussinessLeadContract $BusinessLeadRepository, EventformatContract $eventformatRepository, LanguageContract $languageRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->CategoryRepository = $CategoryRepository;
        $this->BusinessLeadRepository = $BusinessLeadRepository;
        $this->eventformatRepository = $eventformatRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        if (!empty($request->category)||!empty($request->from)||!empty($request->to)||!empty($request->keyword)) {
            $category = !empty($request->category) ? $request->category : '';
            $from = !empty($request->from) ? $request->from : '';
            $to = !empty($request->to) ? $request->to : '';
            $keyword = !empty($request->keyword) ? $request->keyword : '';
            $events = $this->eventRepository->searchEventsData($category,$from,$to,$keyword);
        }else{
            $events = Event::where('created_by',Auth::guard('business')->user()->id)->paginate(25);
        }
        //dd($events);
        $categories = $this->eventRepository->listCategories();
        //dd($categories);
        $this->setPageTitle('Event', 'List of all event');
        return view('business.event.index', compact('events','categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->eventRepository->listCategories();
        $businesses = $this->BusinessLeadRepository->listBusinesssLead();
        $state=State::all();
        $this->setPageTitle('Event', 'Create Event');
        return view('business.event.create', compact('categories','businesses','state'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'category_id'      =>  'required',
            'directory_id'      =>  'nullable',
            'title'      =>  'required|max:191',
            'host'      =>  'required',
           // 'link'      =>  'required',
            'type'      =>  'required',
            'title'      =>  'required',
            'start_date'      =>  'required',
            'end_date'      =>  'required',
            'start_time'      =>  'required',
            'end_time'      =>  'required',
           // 'address'      =>  'required',
            'is_paid'      =>  'required',
            'image'     =>  'required|mimes:jpg,jpeg,png|max:2000',
        ]);

        $params = $request->except('_token');

        $event = $this->eventRepository->createBusinessEvent($params);

        if (!$event) {
            return redirect()->back()->with('failure','Error occurred while creating event.', 'error', true, true);
        }
        return redirect()->back()->with('success','Event has been added successfully' ,'success',false, false);
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetEvent = $this->eventRepository->findEventById($id);
        $categories = $this->eventRepository->listCategories();
        $businesses = $this->BusinessLeadRepository->listBusinesssLead();
        $eventformats = $this->eventformatRepository->listEventformats();
        $languages = $this->languageRepository->listLanguages();
        $state=State::all();
        $this->setPageTitle('Event', 'Edit Event : '.$targetEvent->title);
        return view('business.event.edit', compact('targetEvent','categories','businesses','eventformats','languages','state'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'category_id'      =>  'nullable',
            'directory_id'      =>  'nullable|max:191',
            'title'      =>  'required|max:191',
            'host'      =>  'required',
            //'link'      =>  'required',
            'type'      =>  'required',
            'title'      =>  'required',
            'start_date'      =>  'required',
            'end_date'      =>  'required',
            'start_time'      =>  'required',
            'end_time'      =>  'required',
            'is_paid'      =>  'required',
            //'address'      =>  'required',
            'image'     =>  'nullable|mimes:jpg,jpeg,png|max:2000',
        ]);

        $params = $request->except('_token');

        $event = $this->eventRepository->updateBusinessEvent($params);

        if (!$event) {
            return redirect()->back()->with('failure','Error occurred while updating event.', 'error', true, true);
        }
        return redirect()->back()->with('success','Event has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $event = $this->eventRepository->deleteEvent($id);

        if (!$event) {
            redirect()->back()->with('failure','Error occurred while deleting event.', 'error', true, true);
        }
        return redirect()->route('business.event.index')->with('success', 'Event has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){
        // dd($request->all());
        $params = $request->except('_token');

        $event = $this->eventRepository->updateEventStatus($params);

        // dd($event);

        if ($event) {
            return response()->json(array('message' => 'Event status has been successfully updated'));
            // return redirect()->route('business.event.index')->with('success','Event status has been successfully updated','success',false, false);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $events = $this->eventRepository->detailsEvent($id);
        $event = $events[0];

        $this->setPageTitle('Event', 'Event Details : '.$event->title);
        return view('business.event.details', compact('event'));
    }

    public function startStatus()
    {
        $current_date = date('Y-m-d', strtotime('+1day'));
        $userId = Auth::guard('business')->user()->id;

        $data = Event::where('created_by', $userId)->where('start_date', $current_date)->where('before_24_hour_notify', 0)->where('status', 1)->get();

        if (count($data) > 0) {
            foreach($data as $event) {
                $eventUpdate = Event::findOrFail($event->id);
                $eventUpdate->before_24_hour_notify = 1;
                $eventUpdate->save();

                // Notify Diretcory about event starting in 24 hours
                /**
                 * @param int $directoryId
                 * @param string $type
                 * @param object $data
                 */
                directoryNotify($userId, 'event-starts-in-24-hours', $event);
            }
        }
    }

    public function endStatus()
    {
        $current_date = date('Y-m-d', strtotime('+1day'));
        $userId = Auth::guard('business')->user()->id;

        $data = Event::where('created_by', $userId)->where('end_date', $current_date)->where('end_before_24_hour_notify', 0)->where('status', 1)->get();

        if (count($data) > 0) {
            foreach($data as $event) {
                $eventUpdate = Event::findOrFail($event->id);
                $eventUpdate->end_before_24_hour_notify = 1;
                $eventUpdate->save();

                // Notify Diretcory about event starting in 24 hours
                /**
                 * @param int $directoryId
                 * @param string $type
                 * @param object $data
                 */
                directoryNotify($userId, 'event-ends-in-24-hours', $event);
            }
        }
    }

    public function afterEndStatus()
    {
        $current_date = date('Y-m-d');
        $userId = Auth::guard('business')->user()->id;

        $data = Event::where('created_by', $userId)->where('end_date', '<', $current_date)->where('event_end_notify', 0)->where('status', 1)->get();

        if (count($data) > 0) {
            foreach($data as $event) {
                $eventUpdate = Event::findOrFail($event->id);
                $eventUpdate->event_end_notify = 1;
                $eventUpdate->save();

                // Notify Diretcory about event starting in 24 hours
                /**
                 * @param int $directoryId
                 * @param string $type
                 * @param object $data
                 */
                directoryNotify($userId, 'event-expired', $event);
            }
        }
    }
}
