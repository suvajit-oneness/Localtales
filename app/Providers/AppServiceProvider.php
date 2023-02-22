<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            // notification
            $notificationList = [];
            $totalUnreadNotifications = 0;

            $notiTableExists = Schema::hasTable('notifications');

            if ($notiTableExists) {
                if ($user = Auth::guard('business')->user()) {
                    $notificationList = Notification::where('receiver', $user->id)->latest('id')->limit(10)->get();
                    $unreadCount = 0;
                    foreach($notificationList as $index => $noti) {
                        if ($noti->read_flag == 0) {
                            $unreadCount++;
                        }
                    }
                    $notificationList->unreadCount = $unreadCount;

                    $totalUnreadNotifications = Notification::where('receiver', $user->id)->where('read_flag', 0)->count();
                }
            }

            view()->share('notificationList', $notificationList);
            view()->share('totalUnreadNotifications', $totalUnreadNotifications);
        });
    }
}
