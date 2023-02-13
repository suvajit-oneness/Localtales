<?php

namespace App\Http\Controllers\EventOrganiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\EventOrganiser;
use App\Models\State;
use DB;
use Auth;
use Hash;
class ProfileController extends BaseController
{
    public function updatePassword(Request $request) {
        $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_new_password' => 'required|same:new_password|min:6',
            ]);
            $userId = Auth::guard('eventorganiser')->user()->id;
            $check_old_pass = Auth::guard('eventorganiser')->attempt(['email' => auth()->guard('eventorganiser')->user()->email,'password' => $request->old_password]);
            // dd($check_old_pass);
            if (!$check_old_pass) {
                return redirect()->back()->with('failure', 'Old Password is not correct', 'error', true, true);
            }
            $new_pass = Hash::make($request->new_password);
    
           // $user=EventOrganiser::where('id',$userId)->update(['password' => $new_pass]);
           $user = EventOrganiser::findOrFail($userId);
           $user->password =  $new_pass;
           $user->save();
            //Auth::guard('business')->user()->logout();
            if (!$user) {
                return $this->responseRedirectBack('Error occurred while updating Password.', 'error', true, true);
            }else{
            return redirect()->back()->with('success', 'Password has been updated successfully', 'success', false, false);
            }
        }

    public function updateProfile(Request $request)
    {
         //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);
            $userId = Auth::guard('eventorganiser')->user()->id;
            $params = $request->except('_token');
            $params['id'] = $userId;
            $user = EventOrganiser::findOrFail($userId);
            $user->name = !empty($request->name) ? $request->name : '';
            $user->email = !empty($request->email) ? $request->email : '';
            $user->mobile = !empty($request->mobile) ? $request->mobile : '';
            $user->address = !empty($request->address) ? $request->address : '';
            $user->state = !empty($request->state) ? $request->state : '';
            if(!empty($request['postcode'])) {
            $user->postcode = !empty($request->postcode) ? $request->postcode : '';
            }
            if(!empty($request['suburb'])) {
            $user->suburb = !empty($request->suburb) ? $request->suburb : '';
            }
            $user->website = !empty($request->website) ? $request->website : '';
            $user->facebook_link = !empty($request->facebook_link) ? $request->facebook_link : '';
            $user->twitter_link = !empty($request->twitter_link) ? $request->twitter_link : '';
            $user->instagram_link = !empty($request->instagram_link) ? $request->instagram_link : '';
            $user->save();
            //dd($user);
        if (!$user) {
            return redirect()->back()->with('failure', 'Error occurred while updating profile');
        }
            return redirect()->route('eventorganiser.profile')->with('success','You have successfully updated your profile');
    
    }
}
  