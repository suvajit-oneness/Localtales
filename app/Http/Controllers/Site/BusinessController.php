<?php



namespace App\Http\Controllers\Site;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\DirectoryContract;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use App\Contracts\BusinessContract;
use App\Contracts\DirectoryCategoryContract;
use Hash;
// use App\Models\DirectoryCategory;
use App\Models\EventOrganiser;
use App\Http\Controllers\BaseController;

use App\Models\Directory;
use App\Models\Review;
use App\Models\Userbusiness;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Contracts\UserContract;


class BusinessController extends BaseController

{

    protected $DirectoryRepository;

    protected $categoryRepository;



    protected $businessRepository;



    public function __construct(DirectoryContract $DirectoryRepository,DirectoryCategoryContract $DirectoryCategoryRepository,BusinessContract $businessRepository ,UserContract $userRepository)

    {

        $this->DirectoryRepository = $DirectoryRepository;

        $this->DirectoryCategoryRepository = $DirectoryCategoryRepository;

        $this->businessRepository = $businessRepository;
        $this->userRepository = $userRepository;


    }



    /* public function index(Request $request)

    {

        $categoryId = (isset($request->code) && $request->code!='')?$request->code:'';

        $keyword = (isset($request->keyword) && $request->keyword!='')?$request->keyword:'';

        $pinCode = (isset($request->address) && $request->address!='')?$request->address:'';

        $establish_year = (isset($request->establish_year) && $request->establish_year!='')?$request->establish_year:'';

       // $opening_hour = (!empty($request->monday) && !empty($request->tuesday)&& !empty($request->wednesday)&& !empty($request->thursday)&& !empty($request->friday)&& !empty($request->saturday)&& !empty($request->sunday)) ? $request->monday : '' ? $request->tuesday : '' ? $request->wednesday : '' ? $request->thursday : '' ? $request->friday : '' ? $request->saturday : '' ? $request->sunday : '';

         //$opening_hour = (isset($request->monday) && $request->monday!='')?$request->monday:'';

        $sort = (isset($request->sort) && $request->sort!='') ? $request->sort : '';

        $businesses = array();

      //  $businesses_datas = $this->DirectoryRepository->searchDirectoryData($categoryId,$keyword,$pinCode,$establish_year,$opening_hour, $sort);

        //dd($businesses_datas);

        $dir =  Directory::paginate(15);

         $categories = $this->DirectoryRepository->getDirectorycategories($pinCode);

        $this->setPageTitle('Directory', 'List of all Directory');

        return view('site.business.index', compact('pinCode','dir','categories'));

    }



    public function index2(Request $request)

    {

        $categoryId = (isset($request->category_id) && $request->category_id!='')?$request->category_id:'';

        $keyword = (isset($request->keyword) && $request->keyword!='')?$request->keyword:'';

        $pinCode = (isset($request->address) && $request->address!='')?$request->address:'';

        $establish_year = (isset($request->establish_year) && $request->establish_year!='')?$request->establish_year:'';

        $opening_hour = (isset($request->opening_hour) && $request->opening_hour!='')?$request->opening_hour:'';

        $sort = (isset($request->sort) && $request->sort!='') ? $request->sort : '';

        $businesses = array();

        $businesses_datas = $this->DirectoryRepository->searchDirectoryData($categoryId,$keyword,$pinCode,$establish_year,$opening_hour, $sort);

        $dir =  Directory::paginate(15);

        $categories = $this->DirectoryRepository->getDirectorycategories($pinCode);

        $this->setPageTitle('Directory', 'List of all Directory');



        return view('site.business.index2', compact('businesses_datas','pinCode','dir','categories'));

    } */



    public function index3(Request $request)
    {
        $this->setPageTitle('Directory', 'List of all Directory');
        $value = $_COOKIE['postcode'] ?? '';
        $directory = Directory::where('address','LIKE','%' . $value)->paginate(18);

        if (isset($request->code) || isset($request->keyword) || isset($request->name)) {
            // dd($request->all());
            $category = $request->directory_category;
            $code = $request->code;
            $keyword = $request->keyword;
            $type = $request->type;
            $name = $request->name;

            if (!empty($keyword)) {
                //$keywordQuery = "AND address like '%$keyword' ";
                $directoryList = DB::table('directories')->whereRaw("address like '%$keyword'")->paginate(18)->appends(request()->query());
            }
            if (!empty($name)) {
                // DB::enableQueryLog();
                $name = addslashes($name);
                $directoryList = DB::table('directories')->whereRaw("name like '%$name%'")->paginate(18)->appends(request()->query());

                // dd(DB::getQueryLog());
            }

            if (!empty($code)) {
                // if primary category
                if ($type == "primary") {
                    $keywordQuery = "AND name like '%$name%' ";
                    $directoryList = DB::table('directories')->whereRaw("address like '%$keyword' $keywordQuery and
                    ( category_id like '$request->code,%' or category_id like '%,$request->code,%' or category_tree like '%$request->directory_category%')")->paginate(18)->appends(request()->query());
                } elseif ($type == "secondary") {
                    $keywordQuery = "AND name like '%$name%' ";
                    $directoryList = DB::table('directories')->whereRaw("address like '%$keyword' $keywordQuery and
                    ( category_id like '$request->code,%' or category_id like '%,$request->code,%' or category_tree like '%$request->directory_category%')")->paginate(18)->appends(request()->query());
                }
            }
        } else {
              // $directoryList = Directory::paginate(18)->appends(request()->query());
              if(count($directory)>0){
             $directoryList = Directory::where('address','LIKE','%' . $value)->paginate(18)->appends(request()->query());
            }
            else{
             $directoryList = Directory::paginate(18)->appends(request()->query());
            }


            }
           // dd($directoryList);


        return view('site.business.index3', compact('directoryList'));
      }




    public function index3_old(Request $request)

    {

        $categoryId = (isset($request->category_id) && $request->category_id!='')?$request->category_id:'';

        $name = (isset($request->name) && $request->name!='')?$request->name:'';

        $keyword = (isset($request->keyword) && $request->keyword!='')?$request->keyword:'';

        $establish_year = (isset($request->establish_year) && $request->establish_year!='')?$request->establish_year:'';

        $opening_hour = (isset($request->opening_hour) && $request->opening_hour!='')?$request->opening_hour:'';

        $sort = (isset($request->sort) && $request->sort!='') ? $request->sort : '';

        $businesses = array();

        $businesses_datas = $this->DirectoryRepository->searchDirectoryData($categoryId,$name,$keyword,$establish_year,$opening_hour, $sort);

        $dir =  Directory::paginate(15);

        $categories = $this->DirectoryRepository->getDirectorycategories();

        $this->setPageTitle('Directory', 'List of all Directory');



        return view('site.business.index3', compact('businesses_datas','dir','categories'));

    }



    public function detailsUpdated(Request $request, $slug)

    {

        $business = Directory::where('slug', $slug)->first();

        $id = $business->id;



        $businessSaved = 0;

        if(Auth::guard('user')->check()){

            $user_id = Auth::guard('user')->user()->id;

            $ip = $_SERVER['REMOTE_ADDR'];

            // $businessSavedResult = $this->businessRepository->checkUserBusinesses($id,$user_id,$ip);

            $businessSavedResult = Userbusiness::where('directory_id', $id)->where('user_id', $user_id)->where('ip', $ip)->get();



            if(count($businessSavedResult)>0) {

                $businessSaved = 1;

            } else {

                $businessSaved = 0;

            }

        }

        // dd($business);

        $review =  Review::where('directory_id', $id)->get();



        $this->setPageTitle($business->title, 'Directory Details : '.$business->title);



        return view('site.business.details', compact('business', 'businessSaved', 'review'));

    }



    public function details(Request $request,$id)

    {

        $businesses = $this->DirectoryRepository->detailsBusiness($id);

        $business = $businesses[0];



        $businessSaved = 0;

        if(Auth::guard('user')->check()){

            $user_id = Auth::guard('user')->user()->id;

            $ip = $_SERVER['REMOTE_ADDR'];

            $businessSavedResult = $this->businessRepository->checkUserBusinesses($id,$user_id,$ip);



            if(count($businessSavedResult)>0) {

                $businessSaved = 1;

            } else {

                $businessSaved = 0;

            }

        }

        $review =  $this->DirectoryRepository->showreview($id);

        $this->setPageTitle($business->title, 'Directory Details : '.$business->title);

        return view('site.business.details', compact('business', 'businessSaved', 'review'));

    }



    public function saveUserBusiness(Request $request,$id){

        if (Auth::guard('user')->check())  {

            $user_id = Auth::guard('user')->user()->id ?? '';

            $ip = $_SERVER['REMOTE_ADDR'];

            $this->businessRepository->saveUserBusiness($id,$user_id,$ip);

            return $this->responseRedirectBack( 'You have saved this directory' ,'success',false, false);

        } else{

            return redirect()->to('login')->withInput()->with('errmessage', 'Please Login to access restricted area.');

        }

    }



    public function deleteUserBusiness($id){

        $ip = $_SERVER['REMOTE_ADDR'];

        $user_id = Auth::guard('user')->user()->id ?? '';

        $this->businessRepository->deleteUserBusiness($id,$user_id,$ip);



        return $this->responseRedirectBack( 'You have removed this directory from your list' ,'success',false, false);

    }



    public function question(Request $request)

    {

        return view('site.question');

    }



    public function relatedDirectory(Request $request)

    {

        $displayRelated = array();

        $cat = explode(',', $request->category);

        $pincode = (int) \Str::substr($request->address, -4, 4);



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

        $pin11 = $pincode + 6;

        $pin12 = $pincode - 6;



        $pin13 = $pincode + 7;

        $pin14 = $pincode - 7;

        $pin15 = $pincode + 8;

        $pin16 = $pincode - 8;

        $pin17 = $pincode + 9;

        $pin18 = $pincode - 9;

        $pin19 = $pincode + 10;

        $pin20 = $pincode - 10;



        $cat1 = $cat[0];



        if(count($displayRelated)<8){

            $data0 = DB::select("select * from directories where address like '%, ".$pin0."' and category_id like '$cat1,%' and id != ".$request->id." ");



            // dd($pin0, $cat1, $request->id, $data0);



            foreach($data0 as $d){

                array_push($displayRelated,$d);

            }

        }



        $data1 = DB::select("select * from directories where address like '%, ".$pin1."' and category_id like '$cat1,%'");

        $data2 = DB::select("select * from directories where address like '%, ".$pin2."' and category_id like '$cat1,%'");



        // dd($pin1, $pin2, $data1, $data2);



        foreach($data1 as $d){

            array_push($displayRelated,$d);

        }



        foreach($data2 as $d){

            array_push($displayRelated,$d);

        }



        if(count($displayRelated)<8){

            $data3 = DB::select("select * from directories where address like '%, ".$pin3."' and category_id like '$cat1,%'");

            $data4 = DB::select("select * from directories where address like '%, ".$pin4."' and category_id like '$cat1,%'");



            foreach($data3 as $d){

                array_push($displayRelated,$d);

            }



            foreach($data4 as $d){

                array_push($displayRelated,$d);

            }

        }



        if(count($displayRelated)<8){

            $data5 = DB::select("select * from directories where address like '%, ".$pin5."' and category_id like '$cat1,%'");

            $data6 = DB::select("select * from directories where address like '%, ".$pin6."' and category_id like '$cat1,%'");



            foreach($data5 as $d){

                array_push($displayRelated,$d);

            }



            foreach($data6 as $d){

                array_push($displayRelated,$d);

            }

        }



        if(count($displayRelated)<8){

            $data7 = DB::select("select * from directories where address like '%, ".$pin7."' and category_id like '$cat1,%'");

            $data8 = DB::select("select * from directories where address like '%, ".$pin8."' and category_id like '$cat1,%'");



            foreach($data7 as $d){

                array_push($displayRelated,$d);

            }



            foreach($data8 as $d){

                array_push($displayRelated,$d);

            }

        }



        if(count($displayRelated)<8){

            $data9 = DB::select("select * from directories where address like '%, ".$pin9."' and category_id like '$cat1,%'");

            $data10 = DB::select("select * from directories where address like '%, ".$pin10."' and category_id like '$cat1,%'");



            foreach($data9 as $d){

                array_push($displayRelated,$d);

            }



            foreach($data10 as $d){

                array_push($displayRelated,$d);

            }

        }



        if(count($displayRelated)<8){

            $data11 = DB::select("select * from directories where address like '%, ".$pin11."' and category_id like '$cat1,%'");

            $data12 = DB::select("select * from directories where address like '%, ".$pin12."' and category_id like '$cat1,%'");



            foreach($data11 as $d){

                array_push($displayRelated,$d);

            }



            foreach($data12 as $d){

                array_push($displayRelated,$d);

            }

        }



        if(count($displayRelated)<8){

            $data13 = DB::select("select * from directories where address like '%, ".$pin13."' and category_id like '$cat1,%'");

            $data14 = DB::select("select * from directories where address like '%, ".$pin14."' and category_id like '$cat1,%'");



            foreach($data13 as $d){

                array_push($displayRelated,$d);

            }



            foreach($data14 as $d){

                array_push($displayRelated,$d);

            }

        }



        if(count($displayRelated)<8){

            $data15 = DB::select("select * from directories where address like '%, ".$pin15."' and category_id like '$cat1,%'");

            $data16 = DB::select("select * from directories where address like '%, ".$pin16."' and category_id like '$cat1,%'");



            foreach($data15 as $d){

                array_push($displayRelated,$d);

            }



            foreach($data16 as $d){

                array_push($displayRelated,$d);

            }

        }



        if(count($displayRelated)<8){

            $data17 = DB::select("select * from directories where address like '%, ".$pin17."' and category_id like '$cat1,%'");

            $data18 = DB::select("select * from directories where address like '%, ".$pin18."' and category_id like '$cat1,%'");



            foreach($data17 as $d){

                array_push($displayRelated,$d);

            }



            foreach($data18 as $d){

                array_push($displayRelated,$d);

            }

        }



        if(count($displayRelated)<8){

            $data19 = DB::select("select * from directories where address like '%, ".$pin19."' and category_id like '$cat1,%'");

            $data = DB::select("select * from directories where address like '%, ".$pin20."' and category_id like '$cat1,%'");



            foreach($data19 as $d){

                array_push($displayRelated,$d);

            }



            foreach($data as $d){

                array_push($displayRelated,$d);

            }

        }



        $resp = [];

        foreach($displayRelated as $business) {

            // rating

            if ($business->rating == "0" || $business->rating == "" || $business->rating == null) {

                $rating = '';

            } else {

                $rating = $business->rating.' <span class="fa fa-star checked" style="color: #FFA701;"></span>';

            }



            // mobile

            $only_numbers = (int)filter_var($business->mobile, FILTER_SANITIZE_NUMBER_INT);

            if(strlen((string)$only_numbers) == 9) {

                $only_number_to_array = str_split((string)$only_numbers);

                $mobile_number = '(0'.$only_number_to_array[0].') '.$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8];

            } elseif(strlen((string)$only_numbers) == 10) {

                $only_number_to_array = str_split((string)$only_numbers);

                $mobile_number = '('.$only_number_to_array[0].$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].') '.$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8].$only_number_to_array[9];

            } else {

                $mobile_number = $business->mobile;

            }



            // category
            if (!empty($business->category_id)) {
                $cat = substr($business->category_id, 0, -1);
                $catArr = explode(',', $cat);

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

                'id' => $business->id,

                'name' => $business->name,

                'slug' => $business->slug,

                'rating' => $rating,

                'address' => $business->address,

                'mobile' => $mobile_number,

                'category' => $categoryArr,

            ];

        }



        return response()->json(['error' => false, 'resp' => $resp]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profilestore(Request $request){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = Auth::guard('business')->user()->id;
        $params = $request->except('_token');
        $params['id'] = $userId;
        // if($request->state !=''){
        // $address=$request->address.", ".$request->suburb.", ".$request->state.", ".$request->pin;
        // }
        // else{
            $address=$request->address;
        //}
       // dd($address);
        $user=Directory::where('id',$userId)->update([
            'name'=>request('name'),
            'address'=>$address,
            'email'=>request('email'),
            'mobile'=>request('mobile'),
            'trading_name'=>request('trading_name') ?? '',
            'primary_name'=>request('primary_name') ?? '',
            'primary_email'=>request('primary_email') ?? '',
            'primary_phone'=>request('primary_phone') ?? '',
            //'category_id'=>request('category_id')?? '',
            //'category_tree'=>request('category_tree')?? '',
            'service_description'=>request('service_description')?? '',
            'description'=>request('description')?? '',
            'website'=>request('website')?? '',
            'facebook_link'=>request('facebook_link')?? '',
            'twitter_link'=>request('twitter_link')?? '',
            'instagram_link'=>request('instagram_link')?? '',
            'monday'=>request('monday')?? '',
            'tuesday'=>request('tuesday')?? '',
            'wednesday'=>request('wednesday')?? '',
            'thursday'=>request('thursday')?? '',
            'friday'=>request('friday')?? '',
            'saturday'=>request('saturday')?? '',
            'sunday'=>request('sunday')?? '',
            'public_holiday'=>request('public_holiday')?? '',
            'ABN'=>request('ABN')?? '',
            'establish_year'=>request('establish_year')?? '',
            ]);

        if (!$user) {
           // return $this->responseRedirectBack('Error occurred while updating profile.', 'error', true, true);
           return redirect()->back()->with('failure', 'Error occurred while updating profile');
        }
        //return $this->responseRedirect('business.profile', 'You have successfully updated your profile' ,'success',false, false);
        return redirect()->route('business.profile')->with('success','You have successfully updated your profile');
    }

    public function changePassword()
    {
       // dd('here');
        return view('business.changePassword');
    }
    public function updatePassword(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|same:new_password|min:6',
        ]);
        $userId = Auth::guard('business')->user()->id;
        $check_old_pass = Auth::guard('business')->attempt(['email' => auth()->guard('business')->user()->email, 'password' => $request->old_password]);

        if (!$check_old_pass) {
            return redirect()->back()->with('failure', 'Old Password is not correct', 'error', true, true);
        }

        $new_pass = Hash::make($request->new_password);
        $user = Directory::findOrFail($userId);
        $user->password =  $new_pass;
        $user->save();
        //Directory::where('email', auth()->guard('business')->email)->update(['password' => $new_pass]);
        if (!$user) {
            return $this->responseRedirectBack('Error occurred while updating Password.', 'error', true, true);
        }else{
        //Auth::guard('business')->logout();
        return redirect()->back()->with('success', 'Password has been updated successfully', 'success', false, false);
        }
    }
    //review
    public function review(Request $request)
    {
        $review =  Review::where('directory_id', Auth::guard('business')->user()->id)->get();
        return view('business.dashboard.review',compact('review'));
    }
    public function deleteCat(Request $request, $dirId, $catId)
    {
        $data = Directory::findOrFail($dirId);

        $newCategoryId = trim(str_replace(','.$catId, '', $data->category_id));

        Directory::where('id', $dirId)->update([
            'category_id' => $newCategoryId
        ]);
        return redirect()->back()->with('success', 'Directory Category removed successfully', 'success', false, false);
        //return $this->responseRedirectBack('Directory Category removed successfully', 'success', false, false);
    }

    public function storeCat(Request $request)
    {
        // dd($request->all());
        $newCategoryIds = implode(',', $request->catId);

        $dirCat = Directory::findOrFail($request->dirId);
        $updatedCat = $dirCat->category_id.$newCategoryIds.',';

        Directory::where('id', $request->dirId)->update([
            'category_id' => $updatedCat
        ]);
        return redirect()->back()->with('success', 'Directory Category added successfully', 'success', false, false);
        //return $this->responseRedirectBack('Directory Category added successfully', 'success', false, false);
    }
    

}

