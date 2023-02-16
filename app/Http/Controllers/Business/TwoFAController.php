<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\UserCode;
use Auth;
class TwoFAController extends Controller
{
   
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('business.auth.2fa');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required',
        ]);
  
        $find = UserCode::where('business_id', Auth::guard('business')->user()->id)
                        ->where('code', $request->code)
                        ->where('updated_at', '>=', now()->subMinutes(2))
                        ->first();
  
        if (!is_null($find)) {
            Session::put('user_2fa', Auth::guard('business')->user()->id);
            return redirect()->route('business.dashboard.index');
        }
  
        return back()->with('error', 'You entered wrong code.');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function resend()
    {
        Auth::guard('business')->user()->generateCode();
  
        return back()->with('success', 'We sent you code on your email.');
    }
}
