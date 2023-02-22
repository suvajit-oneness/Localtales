<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Review;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::where('directory_id', Auth::guard('business')->user()->id)->orderBy('created_at', 'desc')->paginate(12);
        return view('business.review.index',compact('reviews'));
    }

    public function detail(Request $request, $id)
    {
        $data = Review::where('directory_id', Auth::guard('business')->user()->id)->where('id', $id)->first();

        if ($data) {
            return view('business.review.detail',compact('data'));
        } else {
            return redirect()->route('404');
        }
    }
}
