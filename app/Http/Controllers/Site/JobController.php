<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ApplyJob;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobUser;
use App\Models\JobTag;
use App\Contracts\JobContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Auth;
use View;

class JobController extends Controller {

    protected $JobRepository;

    public function __construct(JobContract $JobRepository)
    {
        $this->JobRepository = $JobRepository;
    }

    public function index(Request $request)
    {
        if (isset($request->keyword) || isset($request->name)) {
            //$category = $request->directory_category;
            //$code = $request->code;
            $keyword = $request->keyword;
            $name = $request->name;
            if (!empty($request->keyword)) {
                $keywordQuery = " AND (address LIKE '%$request->keyword%' OR postcode LIKE '%$request->keyword%' OR suburb LIKE '%$request->keyword%')";
            } else {
                $keywordQuery = "";
            }

            if (!empty($request->name)) {
                $nameQuery = " AND (title LIKE '%$request->name%' OR company_name like '%$request->name%' OR description like '%$request->name%')";
            } else {
                $nameQuery = "";
            }

            $jobs = Job::whereRaw(" status = 1 ".$keywordQuery.$nameQuery)
            ->orderby('id','desc')->paginate(40);
        } else {
            $jobs = Job::where('status',1)->orderby('id','desc')->paginate(16)->appends(request()->query());
        }

        $category = JobCategory::where('status',1)->orderby('title')->get();
        return view('site.job.index',compact('jobs','category'));
    }

    public function details(Request $request,$slug)
    {
        $job = Job::where('slug',$slug)->get();
        $category = JobCategory::where('status',1)->orderby('title')->get();

        // check if job is already applied
        if(Auth::guard('user')->check()){
        // if (Auth::guard('user')->user()->id) {
            $jobApplied = ApplyJob::where('job_id', $job[0]->id)->where('user_id', Auth::guard('user')->user()->id)->first();
        }
        else{
            $jobApplied ='';
        }
        return view('site.job.details',compact('job', 'category','jobApplied'));
    }

    public function store(Request $request){
        $ip = $_SERVER['REMOTE_ADDR'];

	    // check if collection already exists
        if(auth()->guard('user')->check()) {
           $collectionExistsCheck = JobUser::where('job_id', $request->id)->where('user_id', auth()->guard('user')->user()->id)->first();
        } else {
           $collectionExistsCheck = JobUser::where('job_id', $request->id)->where('ip', $ip)->first();
          // return redirect()->route('site.login')->with('failure', 'Something happened');
        }
        if($collectionExistsCheck != null) {
            // if found
            $data = JobUser::destroy($collectionExistsCheck->id);
            return response()->json(['status' => 200, 'type' => 'remove', 'message' => 'Job removed from savelist']);
        } else {
            // if not found
            $data = new JobUser();
            $data->user_id = auth()->guard('user')->user() ? auth()->guard('user')->user()->id : 0;
            $data->job_id = $request->id;
            $data->ip = $ip;
            $data->save();
            return response()->json(['status' => 200, 'type' => 'add', 'message' => 'Job saved']);
        }
	}
    public function applyform(Request $request,$slug)
    {
        if(Auth::guard('user')->check()){
         $job = Job::where('slug',$slug)->get();
        // view('site.job.form',compact('job'));
         return View::make('site.job.form',compact('job'));
        }else{

            return redirect()->route('site.login')->with('failure', 'Login to continue');
        }
    }
    public function jobapply(Request $request){
        // dd($request->all());

        $request->validate([
            'job_id' => 'required|integer|min:1',
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|min:2|max:255',
            'mobile' => 'required|integer',
            'cv' => 'required'
        ]);

        $params = $request->except('_token');
        $data = $this->JobRepository->applyjob($params);

        if ($data) {
            return redirect()->back()->with('success', 'Successfully Applied for this Job');
        } else {
            return redirect()->back()->with('failure', 'Something happened');
        }
    }


}
