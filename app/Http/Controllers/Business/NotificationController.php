<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\PushNotification;
use App\Models\Directory;
use App\Models\NotificationTypeHead;
use App\Models\NotificationReceiveUser;

class NotificationController extends BaseController
{
    public function index(Request $request)
    {
        $user = Auth::guard('business')->user();
        $data = Notification::where('receiver', $user->id)->latest()->paginate(25);

        return view('business.notification.index', compact('data'));
    }

    public function read(Request $request)
    {
        $user = Auth::guard('business')->user();
        $noti = Notification::where('receiver', $user->id)->where('id', $request->id)->first();
        $noti->read_flag = 1;
        $noti->save();
    }

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

    public function checkPushNotification(Request $request) {
        $user = Auth::guard('business')->user();
        $data = PushNotification::where('receiver', $user->id)->where('read_flag', 0)->latest('id')->get();

        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Push notifications found',
                'data' => $data
            ]);
        }
    }

    public function readPushNotification(Request $request) {
        $user = Auth::guard('business')->user();
        $data = PushNotification::where('receiver', $user->id)->where('id', $request->id)->first();

        if ($data) {
            $data->read_flag = 1;
            $data->save();

            return response()->json([
                'status' => 200,
                'message' => 'Push notifications read',
                'data' => $data
            ]);
        }
    }

    public function markAllRead(Request $request)
    {
        $user = Auth::guard('business')->user();
        Notification::where('receiver', $user->id)->update([
            'read_flag' => 1
        ]);

        return redirect()->route('business.notification.index')->with('success', 'All unread notifications are marked as read');
    }
}
