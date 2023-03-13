<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SchoolController extends BaseController
{
    public function index(Request $request)
    {
        $this->setPageTitle('News', 'List of all Properties');

        $title = $request->name ?? '';
        $keyword = $request->keyword ?? '';
       
        $query = School::select('*')->where('status',1);
    
        $query->when($title, function($query) use ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        });
        $query->when($keyword, function($query) use ($keyword) {
            $query->where('postcode', 'like', '%' . $keyword . '%')->orWhere('suburb', 'like', '%' . $keyword . '%')->orWhere('short_state', 'like', '%' . $keyword . '%');
        });
        
        
        $schoolList = $query->orderBy('id','desc')->paginate(12);

        return view('site.school.index', compact('schoolList','request'));
    }

    public function detail(Request $request,$slug)
    {
        $schoolList = School::where('slug',$slug)->first();
       
        return view('site.school.detail',compact('schoolList'));
    }
}
