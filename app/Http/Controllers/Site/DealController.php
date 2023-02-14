<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Contracts\DealContract;
use App\Contracts\CategoryContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Auth;
use App\Models\Deal;
use App\Models\DealReview;
use DB;
use Illuminate\Support\Facades\Validator;
class DealController extends BaseController
{
    /**
     * @var DealContract
     */
    protected $dealRepository;
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;


    /**
     * PageController constructor.
     * @param DealContract $dealRepository
     */
    public function __construct(DealContract $dealRepository,CategoryContract $categoryRepository)
    {
        $this->dealRepository = $dealRepository;
        $this->categoryRepository = $categoryRepository;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3094';
        $expiryDate = (isset($request->expiry_date) && $request->expiry_date!='')?$request->expiry_date:'';
        $keyword = (isset($request->keyword) && $request->keyword!='')?$request->keyword:'';
        $categoryId = (isset($request->category_id) && $request->category_id!='')?$request->category_id:'';
         $minPrice = (isset($request->min_price) && $request->min_price!='')?$request->min_price:'';
        $maxPrice = (isset($request->max_price) && $request->max_price!='')?$request->max_price:'';

        if (!empty($request->code)||!empty($request->expiry_date)||!empty($request->keyword)||!empty($request->name)) {
        //$pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3094';
        $expiry_date = (isset($request->expiry_date) && $request->expiry_date!='')?$request->expiry_date:'';
        $category = $request->directory_category;
        $code = $request->code;
        $keyword = $request->keyword;
        $type = $request->type;
        $name = $request->name;
       
        if (!empty($keyword)) {
            //$keywordQuery = "AND address like '%$keyword' ";
            $deals = DB::table('deals')->whereRaw("full_address like '%$keyword'")->paginate(18)->appends(request()->query());
        }
        if (!empty($name)) {
            $deals = DB::table('deals')->whereRaw("title like '%$name%'")->paginate(18)->appends(request()->query());
        }
        if (!empty($expiry_date)) {
            $deals = DB::table('deals')->whereRaw("expiry_date like '%$expiry_date%'")->paginate(18)->appends(request()->query());
        }
        if (!empty($code)) {
            // if primary category
            if ($type == "primary") {
                $keywordQuery = "AND title like '%$name%' ";
                $deals = DB::table('deals')->whereRaw("full_address like '%$keyword' $keywordQuery and
                ( category_id like '$request->code%' or category_id like '%,$request->code%' )")->paginate(18)->appends(request()->query());
            } elseif ($type == "secondary") {
                $keywordQuery = "AND title like '%$name%' ";
                $deals = DB::table('deals')->whereRaw("full_address like '%$keyword' $keywordQuery and
                ( category_id like '$request->code%' or category_id like '%,$request->code%' )")->paginate(18)->appends(request()->query());
            }
        }
        }else{
            $deals = Deal::where('status',1)->orderby('title')->paginate(18);
        }
        //dd($deals);
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

            $data0 = DB::select("select * from deals where pin like '%$pin0%'");
             //dd($pin0, $data0);
            foreach($data0 as $d){

                array_push($displayRelated,$d);

            }

        }
        $data1 = DB::select("select * from deals where pin like '%$pin1%'");

        $data2 = DB::select("select * from deals where pin like '%$pin2%'");
         //dd($pin1, $pin2, $data1, $data2);
        foreach($data1 as $d){

            array_push($displayRelated,$d);

        }
        foreach($data2 as $d){

            array_push($displayRelated,$d);

        }
        if(count($displayRelated)<8){

            $data3 = DB::select("select * from deals where pin like '%$pin3%' ");

            $data4 = DB::select("select * from deals where pin like '%$pin4%' ");
            foreach($data3 as $d){

                array_push($displayRelated,$d);

            }
            foreach($data4 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data5 = DB::select("select * from deals where pin like '%$pin5%' ");

            $data6 = DB::select("select * from deals where pin like '%$pin6%' ");
            foreach($data5 as $d){

                array_push($displayRelated,$d);

            }
            foreach($data6 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data7 = DB::select("select * from deals where pin like '%$pin7%' ");

            $data8 = DB::select("select * from deals where pin like '%$pin8%' ");
            foreach($data7 as $d){

                array_push($displayRelated,$d);

            }

            foreach($data8 as $d){

                array_push($displayRelated,$d);

            }

        }
        if(count($displayRelated)<8){

            $data9 = DB::select("select * from deals where pin like '%$pin9%' ");

            $data10 = DB::select("select * from deals where pin like '%$pin10%' ");

            foreach($data9 as $d){

                array_push($displayRelated,$d);

            }

            foreach($data10 as $d){

                array_push($displayRelated,$d);

            }

        }
        $resp = [];

        foreach($displayRelated as $deal) {
         //dd($displayRelated);
            // category
            if (!empty($deal->category_id)) {
                $catArr = explode(',', $deal->category_id);

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

                'id' => $deal->id,

                'title' => $deal->title,

                'slug' => $deal->slug,

                'image' => $deal->image,

                'short_description' => $deal->short_description,

                'full_address' => $deal->full_address,

                'category' => $categoryArr,

            ];

        }
        //dd($resp);
        $this->setPageTitle('Deals', 'List of all deals');
        return view('site.deal.index', compact('deals','pinCode','categories','expiryDate','keyword','categoryId','minPrice','maxPrice','request','resp'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($slug)
    {
        $deal = Deal::where('slug',$slug)->first();
        //$deal = $deals[0];

        $dealSaved = 0;

        if(Auth::guard('user')->check()){
            $user_id = Auth::guard('user')->user()->id;

            $dealSavedResult = $this->dealRepository->checkUserDeals($id,$user_id);

            if(count($dealSavedResult)>0){
                $dealSaved = 1;
            }else{
                $dealSaved = 0;
            }
        }
        $dealReview=DealReview::where('deal_id',$deal->id)->get();

        $this->setPageTitle($deal->title, 'Deals Details : '.$deal->title);
        return view('site.deal.details', compact('deal','dealSaved','dealReview'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function saveUserDeal($id){
        $user_id = Auth::user()->id;

        $this->dealRepository->saveUserDeal($id,$user_id);

        return $this->responseRedirectBack( 'You have saved this deal' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteUserDeal($id){
        $user_id = Auth::user()->id;

        $this->dealRepository->deleteUserDeal($id,$user_id);

        return $this->responseRedirectBack( 'You have removed this event from your list' ,'success',false, false);
    }
    //store review
    public function reviewstore(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'email' => 'required|string|email|max:255',
            'rating'      =>  'required',
            'comment'      =>  'required|string|min:1',

        ]);
        $deal = new DealReview();
        $deal->user_id = Auth::guard('user')->user()->id ?? '';
        $deal->name = !empty($request->name) ? $request->name : '';
        $deal->deal_id = !empty($request->deal_id) ? $request->deal_id : '';
        $deal->email = !empty($request->email) ? $request->email : '';
        $deal->rating = !empty($request->rating) ? $request->rating : '';
        $deal->comment = !empty($request->comment) ? $request->comment : '';
        $deal->save();
        if($deal){
            return redirect()->back()->with('success', 'Review Added Successfully');
        }
        else{
            redirect()->back()->with('failure', 'Error occurred while registration.', 'error', true, true);
        }
    }
    public function dealAjax(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'      =>  'required|max:191',
            'email' => 'required|string|email|max:255',
            'rating'      =>  'required',
            'comment'      =>  'required|string|min:1',

        ]);

        if (!$validator->fails()) {

                $params = array(
                    'user_id' => Auth::guard('user')->user()->id ?? '',
                    'deal_id' =>  !empty($request->deal_id) ? $request->deal_id : '',
                    'name' =>     !empty($request->name) ? $request->name : '',
                    'email' =>    !empty($request->email) ? $request->email : '',
                    'rating' =>   !empty($request->rating) ? $request->rating : '',
                    'comment' =>  !empty($request->comment) ? $request->comment : '',
                  
                );

                $data = $this->dealRepository->dealReview($params);

                if ($data) {
                    return response()->json(['error' => false, 'message' => 'Review added']);
                } else {
                    return response()->json(['error' => true, 'message' => 'Something happened']);
                }

        } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
    }

}
