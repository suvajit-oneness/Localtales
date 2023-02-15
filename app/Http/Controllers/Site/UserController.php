<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Userbusiness;
use App\Models\UserCollection;

class UserController extends BaseController
{
	public function index() {
        $businesses = Userbusiness::where('user_id', Auth::guard('user')->user()->id)->get();
        $collection = UserCollection::where('user_id', Auth::guard('user')->user()->id)->get();

        return view('site.user.dashboard', compact('businesses', 'collection'));
    }
}
