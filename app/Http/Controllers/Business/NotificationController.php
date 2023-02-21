<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Directory;
use App\Models\NotificationTypeHead;
use App\Models\NotificationReceiveUser;

class NotificationController extends BaseController
{
    public function setup(Request $request) {
        $data = NotificationTypeHead::orderBy('position')->with('notificationLists.notificationReceiveUser')->get()->toArray();

        return view('business.notification.setup', compact('data'));
    }

	public function toggle(Request $request) {
       // $checkNoti = Directory::where('id', Auth::guard('business')->user()->id)->first();
            $noti = Directory::findOrFail(Auth::guard('business')->user()->id);
            $noti->is_2fa_enable = $request->check_status;
            $noti->save();
            return redirect()->route('business.profile')->with('success','You have successfully enabled 2FA Authentication');
    }
}
