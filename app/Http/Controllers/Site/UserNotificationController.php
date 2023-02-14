<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Userbusiness;
use App\Models\UserCollection;
use App\Models\NotificationTypeHead;
// use App\Models\NotificationType;

class UserNotificationController extends BaseController
{
	public function setup() {
        $data = NotificationTypeHead::orderBy('position')->with('notificationLists.notificationReceiveUser')->get()->toArray();

        return view('site.user.notification.setup', compact('data'));
    }
}
