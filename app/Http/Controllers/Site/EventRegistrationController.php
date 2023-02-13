<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\EventOrganiser;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\PinCode;
use App\Models\State;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Hash;
use Str;
use Illuminate\Support\Facades\Crypt;
class EventRegistrationController extends BaseController
{
    public function index(Request $request)
    {
        $this->setPageTitle('Event Organiser Registration', 'Event Organiser Registration');
        $state=State::orderby('name')->get();
        $pin=PinCode::orderby('pin')->get();
        return view('eventorganiser.auth.register',compact('pin','state'));
    }
    public function store(Request $request)
    {
       // dd($request->all());
       $this->validate($request, [
            'name'      =>  'required|string|max:20',
            'email' => 'required|email',
            'postcode' => 'nullable|digits:4',
            'suburb' => 'nullable|string',
        ]);
        $business = new EventOrganiser();
        $business->name = $request->name;
        $business->email = $request->email;
        $business->state = $request->state;
        $business->postcode = $request->postcode;
        $business->suburb = $request->suburb;
        $business->password = bcrypt('Welcome@2022');
        //$business->password = Hash::make(Str::random(10));
        $business->mail_status	 = 1;
        $saved = $business->save();
        //dd(Crypt::decryptString($business->password));
        if ($saved) {
            $template=MailTemplate::where('type', 'like', '%' . 'event-organiser-registration' .'%')->first();
            $data["email"] = $request->email;
            $data["title"] = $template->subject;
            $data["body"] = $template->body;
            $data["image"] = $template->is_image;
            $data["url"]   =  URL::to('/').'/'.'eventorganiser/login';
            Mail::send('frontend.business.mail-template', $data, function($message)use($data) {
                $message->to($data["email"], $data["email"])
                        ->subject($data["title"]);
            });
            return redirect()->route('products.create.step.three');
        }
        else{
            return $this->responseRedirectBack('Error occurred while registration.', 'error', true, true);
        }
    }
}
