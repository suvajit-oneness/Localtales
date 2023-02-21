<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Directory;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class ReviewController extends BaseController
{
    public function index(Request $request)
    {
        $this->setPageTitle('Review', 'List of all Review');

        $directory = $request->name ?? '';
        $keyword = $request->keyword ?? '';
       
        $query = Review::select('reviews.id AS id','reviews.author_name AS author_name','reviews.rating AS rating','reviews.created_at AS created_at','reviews.text AS text','directories.name AS name','directories.address AS address')->join('directories', 'reviews.directory_id', 'directories.id')->where('reviews.status',1);
      
    
        $query->when($directory, function($query) use ($directory) {
            $query->where('directories.name', 'like', '%' . $directory . '%');
        });
        $query->when($keyword, function($query) use ($keyword) {
            $query->where('directories.address', 'like', '%' . $keyword . '%');
        });
        
        if($request->orderBy=="date_desc") {$filterName = "reviews.created_at";$sortOrder = "DESC";}
        elseif($request->orderBy=="rating_asc") {$filterName = "reviews.rating";$sortOrder = "asc";}
        elseif($request->orderBy=="rating_desc") {$filterName = "reviews.rating";$sortOrder = "desc";}
        else {$filterName = "reviews.created_at";$sortOrder = "desc";}
        $reviewList = $query->orderBy($filterName,$sortOrder)->paginate(12);

        //dd($reviewList);
        return view('site.directory.review.index', compact('reviewList','request'));
    }
}
