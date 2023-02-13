<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\AdvocateRegistration;
use App\Contracts\AdvocateRegistrationContract;
use Illuminate\Support\Facades\URL;
class AdvocateRegistrationController extends BaseController
{
    protected $AdvocateRegistrationRepository;

    /**
     * AdvocateRegistrationController constructor.
     * @param AdvocateRegistrationRepository $AdvocateRegistrationRepository
     */

    public function __construct(AdvocateRegistrationContract $AdvocateRegistrationRepository)
    {
        $this->AdvocateRegistrationRepository = $AdvocateRegistrationRepository;
    }

    /**
     * List all the advocate
     */
    public function index(Request $request)
    {

        if (!empty($request->term)) {
            // dd($request->term);
            $advocate = $this->AdvocateRegistrationRepository->getSearchRegistration($request->term);

            // dd($categories);
        } else {
            $advocate =  AdvocateRegistration::latest('id')->paginate(25);
        }
        $this->setPageTitle('Advocates', 'List of all Advocates');
        return view('admin.advocate.index', compact('advocate'));
    }

    public function show(Request $request,$id){
        $targetadvocate = $this->AdvocateRegistrationRepository->detailsRegistration($id);
        $advocate = $targetadvocate[0];
        $this->setPageTitle('Advocates', 'Send Mail : ' . $advocate->title);
        return view('admin.advocate.edit-mail', compact('advocate'));
    }
    public function store(Request $request)
    {
        //dd($request->all());
        if(!empty($request->email)){
            $to = $request->email;
            $subject = $request->subject;
            $content=$request->body;
            $link = '<a href="'.URL::to('/').'/'.'advocate/registration/'.'">REGISTER HERE</a>';
            $body = str_replace("(Embed Link)", $link, $content);
            $message = $body;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            mail($to, $subject, $message, $headers);
            $advocate = AdvocateRegistration::findOrFail($request->id);
            $advocate->mail_status = 1;
            $advocate->save();
            return $this->responseRedirect('admin.advocate.index', 'Mail Send successfully', 'success', false, false);

    }else{
        return $this->responseRedirect('admin.advocate.index', 'No email selected', 'failure', false, false);
    }
   }
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetadvocate = $this->AdvocateRegistrationRepository->detailsRegistration($id);
        $advocate = $targetadvocate[0];
        $this->setPageTitle('Advocates', 'Advocates Details : ' . $advocate->title);
        return view('admin.advocate.details', compact('advocate'));
    }


}
