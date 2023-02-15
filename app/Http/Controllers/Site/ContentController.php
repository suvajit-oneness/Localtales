<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\AboutContract;
use App\Contracts\ContactContract;
use App\Contracts\EventContract;
use App\Contracts\DealContract;
use App\Contracts\DirectoryContract;
use App\Contracts\DirectoryCategoryContract;
use App\Contracts\FaqContract;
use App\Contracts\BlogContract;
use App\Contracts\FaqModuleContract;
use App\Contracts\SuburbContract;
use App\Contracts\PincodeContract;
use App\Models\Directory;
use App\Models\Job;
use App\Models\Setting;
use App\Models\State;
use App\Models\Blog;
use App\Models\PinCode;
use App\Models\Suburb;
use App\Models\DirectoryCategory;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Models\ContactForm;
use App\Models\Subscription;
use Auth;
use Symfony\Component\Console\Input\Input;

class ContentController extends BaseController
{
    protected $AboutRepository;
    /**
     * ContentController constructor.
     */
    public function __construct(
        AboutContract $AboutRepository,
        ContactContract $ContactRepository,
        FaqModuleContract $FaqModuleRepository,
        FaqContract $FaqRepository,
        DealContract $dealRepository,
        EventContract $eventRepository,
        DirectoryContract $DirectoryRepository,
        BlogContract $blogRepository,
        SuburbContract $SuburbRepository,
        DirectoryCategoryContract $DirectoryCategoryRepository,
        PincodeContract $PincodeRepository
    ) {
        $this->AboutRepository = $AboutRepository;
        $this->ContactRepository = $ContactRepository;
        $this->FaqRepository = $FaqRepository;
        $this->FaqModuleRepository = $FaqModuleRepository;
        $this->dealRepository = $dealRepository;
        $this->eventRepository = $eventRepository;
        $this->DirectoryRepository = $DirectoryRepository;
        $this->blogRepository = $blogRepository;
        $this->SuburbRepository = $SuburbRepository;
        $this->DirectoryCategoryRepository = $DirectoryCategoryRepository;
        $this->PincodeRepository = $PincodeRepository;
    }

    public function index()
    {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        $this->setPageTitle('About', 'About Local Tales');
        $about = $this->AboutRepository->listaboutus();
        return view('site.about.index', compact('about'));
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        $this->setPageTitle('Contact', 'Local Tales');
        $content = $this->ContactRepository->listcontactus();
        return view('site.contact.index', compact('content'));
    }
    public function contactFormstore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required',
        ]);
        $contact = new ContactForm();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->mobile = $request->mobile;
        $contact->description = $request->description;
        $saved = $contact->save();
        if ($saved) {
           // return $this->responseRedirect('contact-us', 'Form has been submitted successfully', 'success', false, false);
            return redirect()->route('contact-us')->with('success', 'Thank you for contacting us');
        }
        else{
           // return $this->responseRedirectBack('Error occurred while form submitting.', 'error', true, true);
            return redirect()->route('contact-us')->with('failure', 'Error occurred while form submitting');
        }

    }
    ////email subscription
    public function emailSubscriptionstore(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email' => 'required|string|email|max:255',

        ]);
        $contact = new Subscription();
        $contact->email = $request->email;
        $saved = $contact->save();
        if ($saved) {
           // return $this->responseRedirectBack( 'Form has been submitted successfully', 'success', false, false);
           return redirect()->back()->with('success', 'Email subscribed successfully');
        }
        else{
           // return $this->responseRedirectBack('Error occurred while form submitting.', 'error', true, true);
           return redirect()->back()->with('failure', 'Error occurred while adding');
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faq()
    {
        $this->setPageTitle('Faq', 'Local Tales');
        $faq = $this->FaqRepository->listfaq();
        $content = $this->FaqModuleRepository->listfaq();
        return view('site.faq.index', compact('content', 'faq'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function state(Request $request, $pincode)
    {
        $this->setPageTitle('PostCode', 'Local Tales');
        $event = $this->eventRepository->listEvents();
        $content = $this->dealRepository->listDeals();
        $pinCode = (isset($request->pincode) && $request->pincode != '') ? $request->pincode : '';
        $dir = Directory::where('address', 'LIKE', '%' . $pincode . '%')->paginate(6);
        $article = $this->blogRepository->searchBlogs($pincode);
        $suburb = $this->SuburbRepository->searchSuburb($pincode);
        $latestBlogs = $this->blogRepository->listBlogs();
        $cat = $this->DirectoryRepository->getDirectorycategories();
        $params = $request->except('_token');
        return view('site.postcode.index', compact('content', 'event', 'dir', 'latestBlogs', 'suburb', 'cat', 'article'));
    }

    public function postcodeindex(Request $request)
    {
        $this->setPageTitle('PostCode', 'Local Tales');

        if (!empty($request->keyword)) {
            $pin = DB::table('pin_codes')->where('pin', 'like', '%'.$request->keyword.'%')->orWhere('state_name', 'like', '%'.$request->keyword.'%')->orWhere('state_code', 'like', '%'.$request->keyword.'%')->orderBy('pin')->paginate(18);
        } else {
            $pin = DB::table('pin_codes')->orderBy('pin')->paginate(18);
        }

        return view('site.postcode.home', compact('pin', 'request'));
    }





    public function postcode(Request $request, $pincode)
    {
        $this->setPageTitle('PostCode', $pincode.' Local Tales');

        // postcode details
        $data = PinCode::where('pin', $pincode)->first();

        // suburbs
        $suburbs = Suburb::where('pin_code', '=', $pincode)->get();

        // articles
        $articles = Blog::where('pincode', '=', $pincode)->get();

        // directories
        if (isset($request->code) || isset($request->keyword)) {
            // dd($request->all());
            $category = $request->directory_category;
            $code = $request->code;
            $keyword = $request->keyword;
            $type = $request->type;
            $address=$request->address;

            if (!empty($keyword)) {
                $directories = DB::table('directories')->whereRaw("name like '%$keyword%' and
                ( address like '%$request->address')")->paginate(18)->appends(request()->query());
            } else {
                $directories = "";
            }


            // if primary category
            if ($type == "primary") {
                $directories = DB::table('directories')->whereRaw("address like '%$address' and name like '%$keyword%' and
                ( category_id like '$request->code,%' or category_id like '%,$request->code,%')")->paginate(18)->appends(request()->query());
            } elseif ($type == "secondary") {
                $directories = DB::table('directories')->whereRaw("address like '%$address' and name like '%$keyword%' and
                ( category_id like '$request->code,%' or category_id like '%,$request->code,%')")->paginate(18)->appends(request()->query());
            }


            // if no directory found
            if(count($directories) == 0) {
                $directories = DB::table('directories')->whereRaw("address like '%$address' and
                ( category_tree like '%$category%' )")->paginate(18)->appends(request()->query());
            }
        } else {
            $directories = Directory::where('address', 'LIKE', '%'.$pincode)
            ->paginate(18)
            ->appends(request()->query());
        }

        $jobs = Job::where('postcode', 'LIKE', '%'.$pincode)->where('status',1)->orderby('id','desc')->paginate(8);

        return view('site.postcode.index', compact('data', 'suburbs', 'articles', 'directories','jobs'));
    }




    public function suburbindex(Request $request)
    {
        $this->setPageTitle('Suburb', 'Local Tales');

        if (!empty($request->postcode) || !empty($request->name)) {
            $postcode = (isset($request->postcode) && $request->postcode != '') ? $request->postcode : '';
            $keyword = (isset($request->name) && $request->name != '') ? $request->name : '';
            $suburbData = (isset($request->suburb) && $request->suburb != '') ? $request->suburb : '';
            $suburb = $this->PincodeRepository->searchSuburbData($postcode, $keyword,$suburbData);
        } else {
            $suburb = DB::table('suburbs')->where('status', 1)->orderBy('name')->paginate(9);
        }

        $state = State::orderBy('name')->get();
        return view('site.suburb.index', compact('suburb', 'state'));
    }

    public function suburb(Request $request, $id,$pincode,$name)
    {
        $this->setPageTitle('Suburb', 'Local Tales');
        $event = $this->eventRepository->listEvents();
        $content = $this->dealRepository->listDeals();
        $pinCode = (isset($request->pincode) && $request->pincode != '') ? $request->pincode : '';
        $dir = Directory::where('address', 'LIKE', '%' . $pincode . '%')->paginate(6);
        $data=Suburb::where('id',$id)->get();
        $item=$data[0]->name;
        $state=$data[0]->short_state;
        $pin=$data[0]->pin_code;
        $article = $this->blogRepository->searchBlogs($pincode);
        $suburb = $this->SuburbRepository->searchSuburb($pincode);
        $latestBlogs = $this->blogRepository->listBlogs();
        $cat = $this->DirectoryRepository->getDirectorycategories();
        if (isset($request->category_id) || isset($request->keyword) || isset($request->address)) {
            $categoryId = (isset($request->category_id) && $request->category_id != '') ? $request->category_id : '';
            $keyword = (isset($request->keyword) && $request->keyword != '') ? $request->keyword : '';
            $suburb = (isset($request->address) && $request->address != '') ? $request->address : '';
            $businesses_datas = $this->DirectoryRepository->searchDirectoryDatabyPostcode($categoryId, $keyword,$suburb);
        } else {
           // $businesses_datas = Directory::where('address', 'LIKE', '%' . $item . '%')->where('address', 'LIKE', '%' . $state . '%')->paginate(9);
            $businesses_datas = Directory::where('address', 'LIKE', '%' . $item . '%')
        ->where('address', 'LIKE', '%' . $state . '%')->where('address', 'LIKE', '%' . $pin . '%')->paginate(9)->appends(request()->query());
            // $businesses_datas = Directory::whereRAW("select * FROM directories where address LIKE '%$item%' AND address LIKE '%$state%'")->paginate(9);
        }
        $params = $request->except('_token');
        return view('site.postcode.suburb-index', compact('content', 'event', 'dir', 'latestBlogs', 'suburb', 'cat', 'article', 'pincode', 'businesses_datas','id','data'));
    }

    public function category($slug)
    {
        $this->setPageTitle('Category', 'Local Tales');

        // DONOT use first() here, use get()
        $data = DirectoryCategory::where('parent_category_slug', $slug)->where('type', 1)->get();

        if (count($data) > 0) {
            $type = 'primary';

            $relatedCategories = DirectoryCategory::where('parent_category_slug', '!=', $slug)->where('type', 1)->where('status', 1)->orderby('parent_category')->get();

            // sub categories
            $childCategories = DirectoryCategory::where('parent_category', $data[0]->parent_category)->where('type', 0)->distinct()->paginate(16);
            $childCategoriesGrouped = DirectoryCategory::where('parent_category', $data[0]->parent_category)->where('type', 0)->orderBy('child_category')->groupBy('child_category')->distinct()->paginate(16);

            // directories
            $directoryList = '';
        } else {
            $type = 'secondary';

            $data = DirectoryCategory::where('child_category_slug', $slug)->where('type', 0)->get();

            $relatedCategories = '';

            // sub categories
            $childCategories = '';
            $childCategoriesGrouped = '';

            /*$directoryList = DB::select("SELECT d.* FROM `directories` AS d
            INNER JOIN directory_categories AS dc
            ON dc.id LIKE (d.category_id+',%')
            WHERE dc.child_category_slug = '".$slug."' LIMIT 9");*/

            // updates for banks category only
            if ($slug == 'banks') {
                // dd('here');
                DB::enableQueryLog();

                $directoryList = DB::table('directory_categories')
                ->select('*')
                ->join('directories', 'directories.category_id', '=', 'directory_categories.id')
                // ->where('directory_categories.child_category_slug', $slug)
                ->whereRaw("child_category_slug = '$slug' AND (category_id = '1080,' OR category_id = '1285,' OR category_id = '1412,' OR category_id = '1472,' OR category_id = '1618,' OR category_id = '1619,' OR category_id = '1838,' OR category_id = '1853,' OR category_id = '2110,')")
                ->paginate(18);

                // dd(DB::getQueryLog());
            } else {
                $directoryList = DB::table('directory_categories')
                ->select('*')
                ->join('directories', 'directories.category_id', '=', 'directory_categories.id')
                ->where('directory_categories.child_category_slug', $slug)
                ->paginate(18);
            }
        }
        if($data){
            return view('site.category.index', compact('data', 'type', 'relatedCategories', 'childCategories', 'childCategoriesGrouped', 'directoryList'));
        } else {
            return view('site.404');
        }

        /*
        $this->setPageTitle('Category', 'Local Tales');
        $event = DirectoryCategory::where('parent_category_slug',$slug)->where('type',1)->get();
        $data=DirectoryCategory::where('parent_category_slug',$slug)->where('type',1)->get();
        $blog=$data[0];
        //dd($blog[11]);
        $id=$data[0]->id;
        //dd($id);
        $latestBlogs = DB::table('blogs')->where('blog_category_id', 'like', '%'.$id.'%')->where('status',1)->paginate(15);

        //dd($latestBlogs);
        // $cat = $this->DirectoryCategoryRepository->listdirectoryCategories();
        $cat = DirectoryCategory::where('parent_category_slug', '!=', $slug)->where('type',1)->orderby('parent_category')->get();
        $faq = DB::table('category_faqs')->where('category_id', 'like', '%'.$id.'%')->where('status',1)->get();
        $suburb = Suburb::paginate(3);
        return view('site.category.index', compact('event', 'latestBlogs', 'faq', 'suburb', 'cat','blog'));
        */
    }

    public function categoryindex(Request $request)
    {
        $this->setPageTitle('Faq', 'Local Tales Category');
        // all category for search filter
        $allCategories = DirectoryCategory::where('status', 1)->where('parent_category', '!=', null)->where('type', 1)->orderBy('parent_category')->get();

        // categories for displaying
        if (!empty($request->title)) {
            $data = DirectoryCategory::where('type', 1)->where('status', 1)->where('parent_category', 'like', '%'.$request->title.'%')->where('parent_category','!=','adult')->orderBy('parent_category')->paginate(12);
        } else {
            $data = DirectoryCategory::where('type', 1)->where('status', 1)->orderBy('parent_category')->paginate(12);
        }

        return view('site.category.home', compact('allCategories', 'data'));


        /* $this->setPageTitle('Faq', 'Local Tales');
        if ($request->get('title')) {

            $cat = BlogCategory::where('title', 'like', '%' . $request->get('title') . '%')->where('status',1)->paginate(12);
        } else {
            $cat = BlogCategory::orderby('title')->where('status',1)->paginate(12);
        }
        $category = BlogCategory::orderBy('title')->where('status',1)->paginate(12);
        return view('site.category.home', compact('cat', 'category')); */
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms()
    {
        $this->setPageTitle('Terms Of Use', 'Local Tales - Terms Of Use');
        $about = $this->AboutRepository->listaboutus();
        $term = Setting::where('key', 'terms')->get();

        return view('site.about.term',compact('about','term'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privacy()
    {
        $this->setPageTitle('Privacy Policy', 'Local Tales - Privacy Policy');
        $about = $this->AboutRepository->listaboutus();
        $privacy = Setting::where('key', 'Privacy')->get();

        return view('site.about.privacy',compact('about','privacy'));
    }

    public function search(Request $request)
    {
        // $cat = $this->DirectoryRepository->getDirectorycategories();
        // $keyword = (isset($request->title) && $request->title != '') ? $request->title : '';
        // $directoryId = (isset($request->category_id) && $request->category_id != '') ? $request->category_id : '';
        // $dir = $this->DirectoryRepository->searchDirectoryData($directoryId, $keyword);
        // $latestdir = $this->DirectoryRepository->listDirectory();
        // $categories = $this->blogRepository->getBlogcategories();
        // $suburb = $this->SuburbRepository->listSuburb();
        // $this->setPageTitle('Directory List', 'List of blogs');
        // return view('site.postcode.details', compact('dir', 'latestdir', 'categories', 'suburb', 'cat'));

        $data = Directory::where('name', 'LIKE', '%' . $request->name . '%')->limit(10)->get();
        if (count($data) > 0) {
            $resp = [];
            foreach ($data as $item) {
                $resp[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                ];
            }

            return response()->json(['error' => false, 'message' => 'Directory found', 'data'  => $resp]);
        } else {
            return response()->json(['error' => true, 'message' => 'No data found']);
        }
    }

    /**
     * @param $id
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id, $slug)
    {
        $blogs = $this->DirectoryRepository->detailsDirectory($id);
        $blog = $blogs[0];
        $relatedBlogs = $this->blogRepository->getRelatedBlogs($blog->blog_category_id, $blog->id);
        $latestBlogs = $this->blogRepository->latestBlogs();
        $categories = $this->blogRepository->getBlogcategories();
        $this->setPageTitle($blog->title, 'Directory Details : ' . $blog->title);
        return view('site.postcode.details-page', compact('blog', 'relatedBlogs', 'latestBlogs', 'categories'));
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function directory()
    {
        $this->setPageTitle('Faq', 'Local Tales');
        $event = $this->eventRepository->listEvents();
        $content = $this->dealRepository->listDeals();
        $dir =  $this->DirectoryRepository->listDirectory();
        $suburb = $this->SuburbRepository->listSuburb();
        $latestBlogs = $this->blogRepository->listBlogs();
        $cat = $this->DirectoryRepository->getDirectorycategories();
        return view('site.postcode.index', compact('content', 'event', 'dir', 'latestBlogs', 'suburb', 'cat'));
    }
}
