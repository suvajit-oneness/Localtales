<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Subscription;
class SubscriptionController extends BaseController
{
    public function index(Request $request){
        $subscription=Subscription::latest('id')->paginate(25);
        $this->setPageTitle('Email Subscription', 'Email Subscription');
        return view('admin.subscription.index', compact('subscription'));
      }

      public function detail(Request $request,$id){
        $target=Subscription::where('id',$id)->get();
        $subscription = $target[0];
        $this->setPageTitle('Email Subscription', 'Email Subscription');
        return view('admin.subscription.details', compact('subscription'));
      }
}
