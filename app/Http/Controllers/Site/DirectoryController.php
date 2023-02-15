<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Directory;
use App\Models\Userbusiness;
use App\Models\Review;

class DirectoryController extends BaseController
{
    public function index(Request $request)
    {
        $this->setPageTitle('Directory', 'List of all Directory');
        $value = $_COOKIE['postcode'] ?? '';
        $directory = Directory::where('address','LIKE','%' . $value)->paginate(18);

        if (isset($request->code) || isset($request->keyword) || isset($request->name)) {
            $category = $request->directory_category;
            $code = $request->code;
            $keyword = $request->keyword;
            $type = $request->type;
            $name = $request->name;

            if (!empty($keyword)) {
                $directoryList = DB::table('directories')->whereRaw("address like '%$keyword'")->paginate(18)->appends(request()->query());
            }
            if (!empty($name)) {
                $name = addslashes($name);
                $directoryList = DB::table('directories')->whereRaw("name like '%$name%'")->paginate(18)->appends(request()->query());
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
            if(count($directory)>0){
                $directoryList = Directory::where('address','LIKE','%' . $value)->paginate(18)->appends(request()->query());
            } else {
                $directoryList = Directory::paginate(18)->appends(request()->query());
            }
        }

        return view('site.directory.index', compact('directoryList'));
    }

    public function detail(Request $request, $slug)
    {
        $business = Directory::where('slug', $slug)->first();
        $id = $business->id;
        $businessSaved = 0;

        if(Auth::guard('user')->check()){
            $user_id = Auth::guard('user')->user()->id;
            $ip = $_SERVER['REMOTE_ADDR'];

            $businessSavedResult = Userbusiness::where('directory_id', $id)->where('user_id', $user_id)->where('ip', $ip)->get();


            if(count($businessSavedResult)>0) {
                $businessSaved = 1;
            } else {
                $businessSaved = 0;
            }
        }

        $review =  Review::where('directory_id', $id)->get();
        $this->setPageTitle($business->title, 'Directory Details : '.$business->title);

        return view('site.directory.detail', compact('business', 'businessSaved', 'review'));
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

}
