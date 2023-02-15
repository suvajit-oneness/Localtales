<?php

namespace App\Http\Controllers\Business;

use App\Contracts\BlogContract;
use App\Contracts\BusinessContract;
use App\Contracts\DirectoryContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\BusinessSignupPage;
use App\Models\Collection;
use App\Models\CollectionDirectory;
use App\Models\Directory;
use App\Models\DirectoryCategory;
use App\Models\MailTemplate;
use App\Models\PinCode;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SignupController extends BaseController
{
    /**
     * @var DirectoryContract
     */
    protected $DirectoryRepository;
    /**
     * @var BlogContract
     */
    protected $BlogRepository;
    /**
     * HomeController constructor.
     * @param DirectoryContract $eventRepository
     * @param BlogContract $BlogRepository

     */
    public function __construct(DirectoryContract $DirectoryRepository, BlogContract $BlogRepository, BusinessContract $businessRepository)
    {
        $this->DirectoryRepository = $DirectoryRepository;
        $this->BlogRepository = $BlogRepository;
        $this->businessRepository = $businessRepository;
    }
    public function businesssignup(Request $request)
    {
        $this->setPageTitle('Business ', 'Business Signup');
        $dircategory = $this->DirectoryRepository->getDirectorycategories();
        $directory = $request->session()->get('directory');
        return view('frontend.business.signup', compact('dircategory', 'directory'));
    }
    // public function createStepOne(Request $request)
    // {
    //     $product = $request->session()->get('product');

    //     return view('products.create-step-one',compact('product'));
    // }
    public function businesssignuppage(Request $request, $id)
    {
        $this->setPageTitle('Business ', 'Business Signup');
        $dircategory = $this->DirectoryRepository->getDirectorycategories();
        $dir = Directory::where('id', $id)->get();
        $directory = $dir[0];
        return view('frontend.business.signuppage', compact('dircategory', 'directory'));
    }
    public function registrationform(Request $request)
    {
        $this->setPageTitle('Business ', 'Business Signup');
        $dircategory = $this->DirectoryRepository->getDirectorycategories();
        return view('frontend.business.registration-form', compact('dircategory', ));
    }
    public function businessform(Request $request, $slug)
    {
        $this->setPageTitle('Business ', 'Business Signup');
        $dir = Directory::where('slug', $slug)->get();
        $directory = $dir[0];
        //dd($directory);
        $dircategory = $this->DirectoryRepository->getDirectorycategories();
        return view('frontend.business.signuppage', compact('dircategory', 'directory'));
    }
    public function businessstore(Request $request)
    {
        $validatedData = $request->validate([
            //  'name'      =>  'required|min:1',
            'email' => 'required|email|min:1',
            // 'password'      =>  'required|min:1',
            'name' => 'required|string|min:1',

        ]);

        if (empty($request->session()->get('directory'))) {
            $directory = new Directory();
            $directory->fill($validatedData);
            $request->session()->put('directory', $directory);
        } else {
            $directory = $request->session()->get('directory');
            $directory->fill($validatedData);
            $request->session()->put('directory', $directory);
        }

        return redirect()->route('business.signup');
    }
    public function store(Request $request)
    {

        $this->validate($request, [
            'council_name' => 'required|max:191',
            'primary_contact' => 'required | max:191',
            'email' => 'required | max:191',
            'contact_no' => 'required | max:191',
        ]);
        $business = new BusinessSignupPage();
        $business->council_name = $request->council_name;
        $business->primary_contact = $request->primary_contact;
        $business->email = $request->email;
        $business->contact_no = $request->contact_no;
        $saved = $business->save();

        if ($saved) {

            $to = $request->email;

            $subject = "Thank You for Registered!";

            $message = "<p>Hello and welcome to Local Tales,<br>
            <br>
            We are always looking to work with the local leaders and champions of the community and that <br>
            is exactly what councils like yours offer. We understand how important you are to engaging the <br>
            community and spreading a positive message to your people.</p>

            <p>So, what is Local Tales? We&rsquo;re a brand-new site aimed at bringing the community together. We <br>
            offer users an easy way to find local businesses, events, deals and much more throughout <br>
            Australia.</p>

            <p>What do we need from you? We want to utilise your expertise and knowledge of your districts so <br>
            we can benefit the local community. We would like to request access to your local events <br>
            database in order to assist with maximising it&rsquo;s reach to your constituents, using our site. <br>
            What will this accomplish?</p>

            <p>&middot; A new way to reach a larger audience in the community. <br>
            &middot; Better connections between your council and members. <br>
            &middot; Increased attendance at the events you hold. <br>
            &middot; An even greater sense of community through participation.</p>

            <p>If you would be interested in working with us to bring people together in new and exciting ways, <br>
            please follow the link below to register your interest. We will then send more information about <br>
            the launch of the site in the coming weeks and connect your database to showcase your events <br>
            to our wider audience.</p>

            <p>Alternatively, if you would like a call to discuss this opportunity, please reply and I&rsquo;d be happy to <br>
            set up a call.</p>

            <br>
            Thank you for reading. <br>
            Local Tales Founder, <br>
            David Brennan</p>";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            mail($to, $subject, $message, $headers);
        }

        // if(empty($request->session()->get('directory'))){
        //     $directory = new Directory();
        //     $directory->fill($validatedData);
        //     $request->session()->put('directory', $directory);
        // }else{
        //     $directory = $request->session()->get('directory');
        //     $directory->fill($validatedData);
        //     $request->session()->put('directory', $directory);
        // }

        return redirect()->route('products.create.step.three');
        // } else {
        //     return redirect()->route('business.signup')->withInput($request->all())->withErrors($validatedData->errors());
        // }
    }

    public function pagestore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:directories',
            'mobile' => 'required|digits:10',
            //'password' => 'required|string|min:6',
        ]);
        $business = new Directory();
        $business->name = $request->name;
        $business->trading_name = $request->trading_name;
        $business->email = $request->email;
        $business->address = $request->address;
        $business->mobile = $request->mobile;
        // $business->pin = $request->pin;
        $business->description = $request->description;
        $business->service_description = $request->service_description;
        $business->category_id = $request->category_id;
        $business->opening_hour = $request->opening_hour;
        $business->primary_name = $request->primary_name;
        $business->primary_email = $request->primary_email;
        $business->primary_phone = $request->primary_phone;
        $business->website = $request->website;
        $business->twitter_link = $request->twitter_link;
        $business->password = bcrypt('Welcome@2022');
        $saved = $business->save();

        if ($saved) {
            $template = MailTemplate::where('type', 'like', '%' . 'business-signup' . '%')->first();
            $data["email"] = $request->email;
            $data["title"] = $template->subject;
            $data["body"] = $template->body;
            $data["image"] = $template->is_image;
            $data["url"] = URL::to('/') . '/' . 'business/login';

            Mail::send('frontend.business.mail-template', $data, function ($message) use ($data) {
                $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);

            });
            return redirect()->route('products.create.step.three');
        } else {
            return $this->responseRedirectBack('Error occurred while registration.', 'error', true, true);
        }
    }

    public function createStepThree(Request $request)
    {
        $directory = $request->session()->get('directory');

        return view('frontend.business.thankyou', compact('directory'));
    }

    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function businessformUpdate(Request $request, $slug)
    {
        $dirId = Directory::where('slug', $slug)->get();
        $id = $dirId[0]->id;
        //dd($id->id);
        $business = Directory::findOrFail($id);
        $business->name = $request->name;
        $business->trading_name = $request->trading_name;
        $business->email = $request->email;
        $business->address = $request->address;
        $business->mobile = $request->mobile;
        // $business->pin = $request->pin;
        $business->description = $request->description;
        $business->service_description = $request->service_description;
        $business->category_id = $request->category_id;
        $business->opening_hour = $request->opening_hour;
        $business->primary_name = $request->primary_name;
        $business->primary_email = $request->primary_email;
        $business->primary_phone = $request->primary_phone;
        $business->website = $request->website;
        $business->twitter_link = $request->twitter_link;
        $business->mail_redirect_update = 1;
        $business->save();

        return redirect()->route('products.create.step.three');
    }
    public function postCreateStepThree(Request $request)
    {
        $directory = $request->session()->get('directory');
        $request->session()->forget('directory');

        return redirect()->route('index');
    }

}