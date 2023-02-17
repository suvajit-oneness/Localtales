<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Directory;
class NotificationController extends BaseController
{
    public function setup(Request $request) {
        $data = Directory::where('id', Auth::guard('business')->user()->id)->first();

        return view('business.notification.index', compact('data'));
    }

	public function toggle(Request $request) {
       // $checkNoti = Directory::where('id', Auth::guard('business')->user()->id)->first();
            $noti = Directory::findOrFail(Auth::guard('business')->user()->id);
            $noti->is_2fa_enable = $request->check_status;
            $noti->save();
            return redirect()->route('business.profile')->with('success','You have successfully enabled 2FA Authentication');
    }
}
