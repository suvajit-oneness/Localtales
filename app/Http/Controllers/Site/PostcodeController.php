<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\PinCode;
use App\Models\Suburb;
use App\Models\Blog;
use App\Models\Directory;
use App\Models\Job;
use App\Models\News;
use App\Models\Property;
class PostcodeController extends BaseController
{
    public function index(Request $request)
    {
        $this->setPageTitle('PostCode', 'Local Tales');

        if (!empty($request->keyword)) {
            $pin = DB::table('pin_codes')->where('pin', 'like', '%'.$request->keyword.'%')->orWhere('state_name', 'like', '%'.$request->keyword.'%')->orWhere('state_code', 'like', '%'.$request->keyword.'%')->orderBy('pin')->paginate(18);
        } else {
            $pin = DB::table('pin_codes')->orderBy('pin')->paginate(18);
        }

        return view('site.postcode.index', compact('pin', 'request'));
    }

    public function detail(Request $request, $pincode)
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
                ( address like '%$request->address')")->where('is_deleted', 0)->paginate(18)->appends(request()->query());
            } else {
                $directories = "";
            }


            // if primary category
            if ($type == "primary") {
                $directories = DB::table('directories')->whereRaw("address like '%$address' and name like '%$keyword%' and
                ( category_id like '$request->code,%' or category_id like '%,$request->code,%')")->where('is_deleted', 0)->paginate(18)->appends(request()->query());
            } elseif ($type == "secondary") {
                $directories = DB::table('directories')->whereRaw("address like '%$address' and name like '%$keyword%' and
                ( category_id like '$request->code,%' or category_id like '%,$request->code,%')")->where('is_deleted', 0)->paginate(18)->appends(request()->query());
            }


            // if no directory found
            if(count($directories) == 0) {
                $directories = DB::table('directories')->whereRaw("address like '%$address' and
                ( category_tree like '%$category%' )")->where('is_deleted', 0)->paginate(18)->appends(request()->query());
            }
        } else {
            $directories = Directory::where('address', 'LIKE', '%'.$pincode)
            ->paginate(18)
            ->appends(request()->query());
        }

        // job
        $jobs = Job::where('postcode', 'LIKE', '%'.$pincode)->where('status',1)->orderby('id','desc')->paginate(8);

        // reviews
        $reviews = DB::select("SELECT d.name, r.* FROM directories AS d
        INNER JOIN reviews AS r ON r.directory_id = d.id
        WHERE d.address like '%$pincode'
        ORDER BY r.created_at DESC
        LIMIT 4");
        //news
        $news = News::where('postcode', 'LIKE', '%'.$pincode)->orderby('id','desc')->take(4)->get();
        //property
        $properties = Property::where('postcode', 'LIKE', '%'.$pincode)->orderby('id','desc')->take(4)->get();
        return view('site.postcode.detail', compact('data', 'suburbs', 'articles', 'directories', 'jobs', 'reviews','news','properties'));
    }

    public function latLngUpdate(Request $request)
    {
        $pin = PinCode::findOrFail($request->id);
        $pin->lat = $request->lat;
        $pin->lng = $request->lng;
        $pin->save();
    }
}
