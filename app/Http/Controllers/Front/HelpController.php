<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\PincodeContract;
use App\Models\HelpComment;
use Session;
use Auth;
use App\Contracts\HelpCategoryContract;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PinCodeExport;
use App\Http\Controllers\BaseController;
use App\Models\HelpCategory;
use App\Models\HelpSubCategory;
use App\Models\HelpArticle;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\Validator;
class HelpController extends BaseController
{
    protected $PincodeRepository;

    /**
     * StateManagementController constructor.
     * @param PincodeRepository $StateRepository
     */

    public function __construct(HelpCategoryContract $HelpcategoryRepository)
    {
        $this->HelpcategoryRepository = $HelpcategoryRepository;
    }

    public function index(Request $request)
    {
        $subcategories =HelpArticle::paginate(6);
        if (!empty($request->term)) {
        $categories = $this->HelpcategoryRepository->getSearchCategories($request->term);
       } else {
        $categories =HelpCategory::all();
       }
        $this->setPageTitle('Help', 'Help page');
        return view('site.help.index',compact('categories','subcategories'));
    }
    public function subcat(Request $request,$slug)
    {
         $categories =HelpCategory::where('slug',$slug)->get();
         $id=$categories[0]->id;
         if (!empty($request->term)) {
          $subcategories = $this->HelpcategoryRepository->getSearchSubCategories($request->term);
         } else {
        $subcategories =HelpArticle::where('cat_id',$id)->get();
        }
        //dd($categories);
        $this->setPageTitle('Help', 'Help page');
        return view('site.help.subcat',compact('categories','subcategories'));
    }
    public function detail(Request $request,$slug)
    {
        $Articleid=HelpArticle::where('slug',$slug)->get();
        $id=$Articleid[0]->id;
       // $subcategories =HelpSubCategory::where('category_id',$id)->get();
       // $categories =HelpArticle::where('cat_id',$id)->get();
        $subcategories =HelpArticle::where('id',$id)->get();
        $article=$subcategories[0];
        $relevantArticle=HelpArticle::where('cat_id',$article->cat_id)->where('id','!=',$id)->get();
        //dd($subcategories);
        $this->setPageTitle('Help detail', 'Help page');
        return view('site.help.detail',compact('article','relevantArticle'));
    }

    /**
     * List all the states
     */
     public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'user_name'      =>   'required|string|min:1',
            'user_email'      =>  'required|string|min:1',
            'type'      =>  'required|string|min:1',
            'comment'      =>  'nullable|string|min:1',

        ]);

             $params = $request->except('_token');

        $state = $this->PincodeRepository->help($params);

        if (!$state) {
            return $this->responseRedirectBack('Error occurred while creating Comment.', 'error', true, true);
        }
        return $this->responseRedirect('index', 'Comment has been created successfully', 'success', false, false);
    }


	public function helpAjax(Request $request)
    {

        $validator = Validator::make($request->all(), [
           'user_name'      =>   'required|string|min:1',
            'user_email'      =>  'required|string|min:1',
            'comment'      =>  'required|string|min:1',

        ]);

        if (!$validator->fails()) {

                $params = array(
                    'user_id' => Auth::guard('user')->user()->id ?? '',
                    'user_name' => $request->user_name ?? null,
                    'user_email' => $request->user_email ?? null,
                    'type' =>   $request->type ?? null,
                    'comment' => $request->comment ?? '',
                    'page'    => $request->page ?? ''
                );

                $data = $this->PincodeRepository->help($params);

                if ($data) {
                    return response()->json(['error' => false, 'message' => 'Comment added']);
                } else {
                    return response()->json(['error' => true, 'message' => 'Something happened']);
                }

        } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetpin = $this->PincodeRepository->detailsPincode($id);
        $pin = $targetpin[0];

        $this->setPageTitle('Postcode', 'Postcode Details : ' . $pin->pin);
        return view('admin.pin.details', compact('pin'));
    }


    public function claimbusiness(Request $request){
        $request->validate([
            'user_name'      =>   'required|string|min:1',
            'user_email'      =>  'required|string|min:1',
            'comment'      =>  'nullable|string|min:1',

        ]);

        $params = $request->except('_token');

        $item = $this->BusinessRepository->claim($params);
        dd($item);

        if (!$item) {
            return $this->responseRedirectBack('Error occurred while creating Comment.', 'error', true, true);
        }
        return redirect()->back()->with('message', 'Comment has been created successfully');

    }

    public function claimAjax(Request $request){

        $validator = Validator::make($request->all(), [
           'user_name'      =>   'required|string|min:1',
            'user_email'      =>  'required|string|min:1',
            'comment'      =>  'required|string|min:1',

        ]);

        if (!$validator->fails()) {

                $params = array(
                    'user_id' => Auth::guard('user')->user()->id ?? '',
                    'user_name' => $request->user_name ?? null,
                    'user_email' => $request->user_email ?? null,
                    'directory_id' =>$request->directory_id ?? null,
                    'comment' => $request->comment ?? '',

                );
                dd($params);
                $data = $this->BusinessRepository->claim($params);

                if ($data) {
                    return response()->json(['error' => false, 'message' => 'Comment added']);
                } else {
                    return response()->json(['error' => true, 'message' => 'Something happened']);
                }

               } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
            }

         }
}
