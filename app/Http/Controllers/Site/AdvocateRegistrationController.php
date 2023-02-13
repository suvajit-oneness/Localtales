<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AdvocateRegistration;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\PinCode;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
class AdvocateRegistrationController extends BaseController
{
    public function index(Request $request)
    {
        $this->setPageTitle('Advocate Registration', 'Advocate Registration');
        $pin=PinCode::orderby('pin')->get();
        return view('site.advocate.registration.index',compact('pin'));
    }
    public function store(Request $request)
    {
       // dd($request->all());
       $this->validate($request, [
            'name'      =>  'required|string|max:20',
            'email' => 'required|email',
            'postcode' => 'nullable|digits:4',
            'suburb' => 'nullable|string',
            'platform' => 'nullable',
        ]);
        $business = new AdvocateRegistration();
        $business->name = $request->name;
        $business->email = $request->email;
        $business->postcode = $request->postcode;
        $business->suburb = $request->suburb;
        $business->platform = $request->platform;
        $business->mail_status	 = 1;
        $saved = $business->save();
        if ($saved) {
            $template=MailTemplate::where('type', 'like', '%' . 'advocate-registration' .'%')->first();
            $data["email"] = $request->email;
            $data["title"] = $template->subject;
            $data["body"] = $template->body;
            $data["image"] = $template->is_image;
            $data["url"]   =  URL::to('/').'/'.'';
            Mail::send('frontend.business.mail-template', $data, function($message)use($data) {
                $message->to($data["email"], $data["email"])
                        ->subject($data["title"]);
            });
            return redirect()->route('products.create.step.three');
        }
        else{
            return $this->responseRedirectBack('Error occurred while registration.', 'error', true, true);
        }
        //return redirect()->route('products.create.step.three');

    }
}
