<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Directory;
use App\Models\ReviewVote;
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


     //review like store
     public function likeStore(Request $request){
	    // check if review already exists
        if(Auth::guard('user')->check()){
           $reviewExistsCheck = ReviewVote::where('review_id', $request->id)->where('user_id', auth()->guard('user')->user()->id)->first();
        } else {
           $reviewExistsCheck  = ReviewVote::where('review_id', $request->id)->first();
        }
        //$count=ReviewVote::where('review_id',$request->id)->get()->count();
        if($reviewExistsCheck != null) {
            $reviewDetails=ReviewVote::where('review_id', $request->id)->where('user_id', auth()->guard('user')->user()->id)->where('vote_status',0)->first();
            if($reviewDetails == null) {
            // if found
                $data = ReviewVote::destroy($reviewExistsCheck->id);
               // $count= $count-1;
                return response()->json(['status' => 200, 'count'=>$count,'type' => 'remove', 'message' => 'Feedback added']);
            } else {
                // if not found
                $data = ReviewVote::findOrFail($reviewDetails->id);
                $data->vote_status = 1;
                $data->save();
               // $count = $count+1;
                return response()->json(['status' => 200, 'count'=>$count,'type' => 'add', 'message' => 'Feedback added']);
            }
            // if found
            $data = ReviewVote::destroy($reviewExistsCheck->id);
            return response()->json(['status' => 200, 'count'=>$count,'type' => 'remove', 'message' => 'Feedback added']);
        } else {
            // if not found
            $data = new ReviewVote();
            $data->user_id = auth()->guard('user')->user() ? auth()->guard('user')->user()->id : '';
            $data->review_id = $request->id;
            $data->vote_status = 1;
            $data->save();
           // $count = $count+1;
            return response()->json(['status' => 200,'count'=>$count, 'type' => 'add', 'message' => 'Feedback added']);
        }
	}

    //review dislike store
    public function dislikeStore(Request $request){
	    // check if collection already exists
        if(Auth::guard('user')->check()){
            $reviewExistsCheck = ReviewVote::where('review_id', $request->id)->where('user_id', auth()->guard('user')->user()->id)->first();
         } else {
            $reviewExistsCheck =  ReviewVote::where('review_id', $request->id)->first();
         }
         //$count=ReviewVote::where('review_id',$request->id)->get()->count();
        if($reviewExistsCheck != null) {
            $reviewDetails=ReviewVote::where('review_id', $request->id)->where('user_id', auth()->guard('user')->user()->id)->where('vote_status',1)->first();
            if($reviewDetails == null) {
            // if found
                $data = ReviewVote::destroy($reviewExistsCheck->id);
               // $count= $count-1;
                return response()->json(['status' => 200, 'count'=>$count,'type' => 'remove', 'message' => 'Feedback added']);
            } else {
                // if not found
                $data = ReviewVote::findOrFail($reviewDetails->id);
                $data->vote_status = 0;
                $data->save();
                //$count= $count+1;
                return response()->json(['status' => 200, 'count'=>$count,'type' => 'add', 'message' => 'Feedback added']);
            }
        } else {
            // if not found
            $data = new ReviewVote();
            $data->user_id = auth()->guard('user')->user() ? auth()->guard('user')->user()->id : '';
            $data->review_id = $request->id;
            $data->vote_status = 0;
            $data->save();
            //$count= $count+1;
            return response()->json(['status' => 200,'count'=>$count, 'type' => 'add', 'message' => 'Feedback added']);
        }
	}
}
