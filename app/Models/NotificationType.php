<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class NotificationType extends Model
{
    protected $table = 'notification_types';

    public function notificationReceiveUser() {
        if(Auth::guard('user')->check()) {
            return $this->hasMany(NotificationReceiveUser::class, 'notification_type_id', 'id')->where('user_id', Auth::guard('user')->user()->id);
        } else {
            return $this->hasMany(NotificationReceiveUser::class, 'notification_type_id', 'id');
        }
    }
    
}
