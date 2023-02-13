<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\EventOrganiser;
use App\Contracts\EventRegistrationContract;
use Illuminate\Support\Facades\URL;
class EventRegistrationController extends BaseController
{
    protected $EventRegistrationRepository;

    /**
     * eventRegistrationController constructor.
     * @param eventRegistrationRepository $eventRegistrationRepository
     */

    public function __construct(EventRegistrationContract $EventRegistrationRepository)
    {
        $this->EventRegistrationRepository = $EventRegistrationRepository;
    }

    /**
     * List all the event
     */
    public function index(Request $request)
    {

        if (!empty($request->term)) {
            // dd($request->term);
            $event = $this->EventRegistrationRepository->getSearchRegistration($request->term);

            // dd($categories);
        } else {
            $event =  EventOrganiser::latest('id')->paginate(25);
        }
        $this->setPageTitle('Event Organiser', 'List of all Event Organiser');
        return view('admin.event-organiser.index', compact('event'));
    }

    public function show(Request $request,$id){
        $targetevent = $this->EventRegistrationRepository->detailsRegistration($id);
        $event = $targetevent[0];
        $this->setPageTitle('events', 'Send Mail : ' . $event->title);
        return view('admin.event-organiser.edit-mail', compact('event'));
    }
    public function store(Request $request)
    {
        //dd($request->all());
        if(!empty($request->email)){
            $to = $request->email;
            $subject = $request->subject;
            $content=$request->body;
            $link = '<a href="'.URL::to('/').'/'.'event/registration/'.'">REGISTER HERE</a>';
            $body = str_replace("(Embed Link)", $link, $content);
            $message = $body;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            mail($to, $subject, $message, $headers);
            $event = EventOrganiser::findOrFail($request->id);
            $event->mail_status = 1;
            $event->save();
            return $this->responseRedirect('admin.event-organiser.index', 'Mail Send successfully', 'success', false, false);

    }else{
        return $this->responseRedirect('admin.event-organiser.index', 'No email selected', 'failure', false, false);
    }
   }
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetevent = $this->EventRegistrationRepository->detailsRegistration($id);
        $event = $targetevent[0];
        $this->setPageTitle('events organiser', 'events organiser details : ' . $event->name);
        return view('admin.event-organiser.details', compact('event'));
    }


}
