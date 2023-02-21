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

	public function NotificationReceiveType(Request $request) {
        $directory = Directory::findOrFail($request->user_id);

        if($request->type == "notification_email") {
            $directory->notification_email = ($directory->notification_email == 1) ? 0 : 1;
            $directory->save();

            return response()->json([
                'status' => 200,
                'message' => 'Email notifications preference updated'
            ]);
        }

        if($request->type == "notification_push") {
            $directory->notification_push = ($directory->notification_push == 1) ? 0 : 1;
            $directory->save();

            return response()->json([
                'status' => 200,
                'message' => 'Push notifications preference updated'
            ]);
        }

        if($request->type == "notification_in_app") {
            $directory->notification_in_app = ($directory->notification_in_app == 1) ? 0 : 1;
            $directory->save();

            return response()->json([
                'status' => 200,
                'message' => 'In-App notifications preference updated'
            ]);
        }
    }
}
