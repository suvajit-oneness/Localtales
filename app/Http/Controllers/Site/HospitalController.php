<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoctorHospital;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class HospitalController extends BaseController
{
    public function index(Request $request)
    {
        $this->setPageTitle('News', 'List of all Properties');

        $title = $request->name ?? '';
        $keyword = $request->keyword ?? '';
       
        $query = DoctorHospital::select('*')->where('status',1);
    
        $query->when($title, function($query) use ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        });
        $query->when($keyword, function($query) use ($keyword) {
            $query->where('postcode', 'like', '%' . $keyword . '%')->orWhere('suburb', 'like', '%' . $keyword . '%')->orWhere('short_state', 'like', '%' . $keyword . '%');
        });
        
        
        $doctorList = $query->orderBy('id','desc')->paginate(12);

        return view('site.doctor.index', compact('doctorList','request'));
    }

    public function detail(Request $request,$slug)
    {
        $doctorList = DoctorHospital::where('slug',$slug)->first();
       
        return view('site.doctor.detail',compact('doctorList'));
    }
}
