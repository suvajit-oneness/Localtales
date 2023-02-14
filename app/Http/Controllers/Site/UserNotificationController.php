<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\NotificationTypeHead;
use App\Models\NotificationReceiveUser;

class UserNotificationController extends BaseController
{
	public function setup(Request $request) {
        $data = NotificationTypeHead::orderBy('position')->with('notificationLists.notificationReceiveUser')->get()->toArray();

        return view('site.user.notification.setup', compact('data'));
    }

	public function toggle(Request $request) {
        $checkNoti = NotificationReceiveUser::where('user_id', $request->user_id)->where('notification_id', $request->notification_id)->first();

        if (!empty($checkNoti)) {
            $checkNoti->delete();
        } else {
            $noti = new NotificationReceiveUser();
            $noti->user_id = $request->user_id;
            $noti->notification_id = $request->notification_id;
            $noti->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Notification Preference updated'
        ]);
    }
}
