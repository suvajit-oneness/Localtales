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
        $orderBy = $request->orderBy ?? '';
        $query = Review::query();

        $query->when($directory, function($query) use ($directory) {
            // $query->with('directoryDetails')->where('directories.name', 'like', 'gilmour');
            $query->join('directories', 'reviews.directory_id', 'directories.id')
            ->where('directories.name', 'like', '%' . $directory . '%');
        });
        $query->when($keyword, function($query) use ($keyword) {
            $query->join('pin_codes', 'pin_codes.pin', 'directories.address')
            ->where('pin_codes.pin', 'like', '%' . $keyword . '%');
        });

        $reviewList = $query->orderBy('created_at', 'desc')->paginate(12);

        //dd($reviewList);

        // $reviewList = Review::paginate(12)->appends(request()->query());

        /*
        if ( isset($request->keyword) || isset($request->name)|| isset($request->orderBy)) {
            $keyword = $request->keyword;
            $name = $request->name;
            $orderBy = $request->orderBy;
            // order by
            if ($request->orderBy == 'date_desc') {
                $orderByQuery = " time DESC";
            } elseif ($request->orderBy == 'rating_asc') {
                $orderByQuery = "rating ASC";
            
            } else {
                $orderByQuery = "rating DESC";
            }

            if (!empty($request->keyword)) {
                $keywordQuery = " AND (directories.address LIKE '%$request->keyword%' )";
            } else {
                $keywordQuery = "";
            }

            if (!empty($request->name)) {
                $nameQuery = " AND (directories.name LIKE '%$request->name%')";
            } else {
                $nameQuery = "";
            }
            //$reviewList = Review::join('directories', 'directories.id', 'reviews.directory_id')->join('pin_codes', 'pin_codes.pin', 'directories.address')->whereRaw(" reviews.status = 1 ".$keywordQuery.$nameQuery)->orderby('reviews.id','desc')->paginate(12);
            $reviewList = DB::select("SELECT reviews.id AS id,reviews.rating AS rating,reviews.author_name AS author_name,reviews.time AS time, reviews.text AS text,directories.name AS name,directories.address AS address FROM `reviews` AS r
            INNER JOIN directories AS d ON r.directory_id = d.id
            INNER JOIN pin_codes p ON p.pin LIKE '%d.address%'
            WHERE 
             ".$orderByQuery."
            ".$keywordQuery."
            ".$nameQuery."
           ");
        } else {
           
            $reviewList = Review::paginate(12)->appends(request()->query());
            
        }
        */

        return view('site.directory.review.index', compact('reviewList','request'));
    }
}
