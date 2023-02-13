<?php

namespace App\Http\Controllers\Front;

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

class IndexController extends BaseController
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

    public function index()
    {
        $this->setPageTitle('Splash ', 'Splash Screen');
        $data = Setting::where('key', '=', 'Splash Screen')->get();

        $directory = Directory::select('id')->count();
        $postcode = PinCode::count();
        $collection = Collection::count();
        return view('site.index', compact('data', 'directory', 'postcode', 'collection'));
    }

    public function collection(Request $request, $id)
    {
        $this->setPageTitle('Collection ', 'Collection Screen');
        $data = Setting::where('key', '=', 'Collection')->get();
        $datas = Collection::limit(1)->get();
        $leaduser = Collection::where('id', '!=', $id)->where('status', 1)->paginate(16);
        $col = Collection::where('id', $id)->get();
        $dir = $col[0];
        //dd($dir);
        $businessSaved = 0;
        if (Auth::guard('user')->check()) {
            $user_id = Auth::guard('user')->user()->id;
            //dd($user_id);
            $ip = $_SERVER['REMOTE_ADDR'];
            $businessSavedResult = $this->businessRepository->checkUserCollection($id, $user_id, $ip);

            if (count($businessSavedResult) > 0) {
                $businessSaved = 1;
            } else {
                $businessSaved = 0;
            }
        }

        $businesses = array();
        // $categories = $this->DirectoryRepository->directorywisecollection($id);
        $cat = DirectoryCategory::orderBy('title')->get();
        // dd($category);
        return view('frontend.collection', compact('data', 'datas', 'businessSaved', 'leaduser', 'dir', 'id', 'cat'));
    }

    public function collectionUpdated(Request $request, $slug)
    {
        $this->setPageTitle('Collection ', 'Collection');

        $collectionData = Collection::where('slug', $slug)->first();
        $moreCollections = Collection::where('slug', '!=', $slug)->where('status', 1)->paginate(16);
        $directories = $this->DirectoryRepository->directorywisecollection($collectionData->id);
        $allCategoriesForMapView = CollectionDirectory::where('collection_id', $collectionData->id)->with('directory')->get();

        return view('frontend.collection', compact('collectionData', 'moreCollections', 'directories', 'allCategoriesForMapView'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function saveUserCollection(Request $request, $id)
    {

        if (Auth::guard('user')->check()) {
            //   dd('here');

            //$user_id = Auth::user()->id;
            $user_id = auth()->guard('user')->id();
            $ip = $_SERVER['REMOTE_ADDR'];

            $this->businessRepository->saveUserCollection($id, $user_id, $ip);
            //  dd($request->all());
            return $this->responseRedirectBack('You have saved this directory', 'success', false, false);
        } else {
            return redirect()->to('login')->withInput()->with('errmessage', 'Please Login to access restricted area.');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteUserCollection($id)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_id = Auth::user()->id;
        $this->businessRepository->deleteUserCollection($id, $user_id, $ip);

        return $this->responseRedirectBack('You have removed this collection from your list', 'success', false, false);
    }

    public function page($id)
    {
        //dd($id);
        $this->setPageTitle('Collection ', 'Collection Screen');
        $categories = $this->DirectoryRepository->directorywisecollection($id);
        return view('frontend.collection-directory', compact('categories'));
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Directory', 'Create Directory');
        $dircategory = $this->DirectoryRepository->getAllcategory();
        return view('admin.directory.create', compact('dircategory'));
    }

    public function categoryWiseDirectory(Request $request, $id)
    {
        //dd($id);
        $cat = $this->DirectoryRepository->getDirectorycategories();
        $category = DirectoryCategory::findOrFail($id);
        if (isset($request->category) || isset($request->keyword) || isset($request->name)) {
            $categoryId = !empty($request->category) ? $request->category : '';
            $name = !empty($request->name) ? $request->name : '';
            $keyword = !empty($request->keyword) ? $request->keyword : '';
            $businesses = array();
            $businesses_datas = Directory::
                when($categoryId != '', function ($query) use ($categoryId) {
                $query->where('category_tree', 'like', $categoryId . ',%');
            })
                ->when($name, function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                })
                ->when($keyword, function ($query) use ($keyword) {
                    $query->where('address', 'LIKE', '%' . $keyword);
                })
                ->orderBy('id', 'asc')
                ->paginate(15)
                ->appends(request()->query());

            // $businesses_datas = $this->DirectoryRepository->searchDirectorybyData($categoryId,$keyword,$name,$establish_year,$opening_hour, $sort);
        } else {
            $businesses_datas = Directory::where('category_tree', 'LIKE', '%' . $category->title . '%')->paginate(15)->appends(request()->query());
        }
        //dd($category);
        //  $categories = $this->DirectoryRepository->getDirectorycategories($pinCode);
        $this->setPageTitle('Directory', 'Category wise Directory');
        $data = Directory::where('category_id', 'LIKE', '%' . $id . ',%')->paginate(24)->appends(request()->query());

        return view('site.business.category', compact('data', 'id', 'cat', 'businesses_datas', 'category'));
    }

    public function reviewstore(Request $request)
    {

        $business = new Review();
        $business->name = $request->name;
        $business->directory_id = $request->directory_id;
        $business->email = $request->email;
        $business->rating = $request->rating;
        $business->comment = $request->comment;

        $business->save();

        // if(empty($request->session()->get('directory'))){
        //     $directory = new Directory();
        //     $directory->fill($validatedData);
        //     $request->session()->put('directory', $directory);
        // }else{
        //     $directory = $request->session()->get('directory');
        //     $directory->fill($validatedData);
        //     $request->session()->put('directory', $directory);
        // }

        return redirect()->back()->with('success', 'Review Added Successfully');
        // } else {
        //     return redirect()->route('business.signup')->withInput($request->all())->withErrors($validatedData->errors());
        // }
    }
}
