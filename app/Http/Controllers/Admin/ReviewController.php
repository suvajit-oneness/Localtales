<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
class ReviewController extends BaseController
{
    public function index(Request $request){
        $this->setPageTitle('Review','Review');
        // $review=Review::orderby('created_at','desc')->paginate(25);
        $directory = $request->name ?? '';
        $keyword = $request->keyword ?? '';
       
        $query = Review::select('reviews.id AS id','reviews.author_name AS author_name','reviews.rating AS rating','reviews.created_at AS created_at','reviews.text AS text','reviews.status AS status','reviews.type AS type','directories.name AS name','directories.address AS address')->join('directories', 'reviews.directory_id', 'directories.id');
      
    
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
        $review = $query->orderBy($filterName,$sortOrder)->paginate(25);
        //dd($review);
        return view('admin.review.index', compact('review','request'));
    }

     /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $data = Review::where('id',$id)->delete();

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Review.', 'error', true, true);
        }
        return $this->responseRedirect('admin.review.index', 'Review has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $data = Review::findOrFail($request->id);
        $data->status = $request['check_status'];
        $data->save();
        if ($data) {
            return response()->json(array('message' => 'Review status has been successfully updated'));
        }
    }

    public function details($id)
    {
        $data = Review::where('id',$id)->first();
        $this->setPageTitle('Review Details: ','Review Details : ');

        return view('admin.review.details', compact('data'));

    }
}
