<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTypeHead extends Model
{
    protected $table = 'notification_type_heads';

    public function notificationLists() {
        return $this->hasMany(NotificationType::class, 'head_id', 'id')->where('status', 1);
    }
    
}
