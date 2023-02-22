<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Hash;
use App\Models\Review;
use App\Models\DirectoryCategory;
use App\Models\Directory;
use App\Models\Userbusiness;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    /** update profile
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profilestore(Request $request){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = Auth::guard('business')->user()->id;
        $params = $request->except('_token');
        $params['id'] = $userId;
        // if($request->state !=''){
        // $address=$request->address.", ".$request->suburb.", ".$request->state.", ".$request->pin;
        // }
        // else{
            $address=$request->address;
        //}
       // dd($address);
        $user=Directory::where('id',$userId)->update([
            'name'=>request('name'),
            'address'=>$address,
            'email'=>request('email'),
            'mobile'=>request('mobile'),
            'trading_name'=>request('trading_name') ?? '',
            'primary_name'=>request('primary_name') ?? '',
            'primary_email'=>request('primary_email') ?? '',
            'primary_phone'=>request('primary_phone') ?? '',
            //'category_id'=>request('category_id')?? '',
            //'category_tree'=>request('category_tree')?? '',
            'service_description'=>request('service_description')?? '',
            'description'=>request('description')?? '',
            'website'=>request('website')?? '',
            'facebook_link'=>request('facebook_link')?? '',
            'twitter_link'=>request('twitter_link')?? '',
            'instagram_link'=>request('instagram_link')?? '',
            'monday'=>request('monday')?? '',
            'tuesday'=>request('tuesday')?? '',
            'wednesday'=>request('wednesday')?? '',
            'thursday'=>request('thursday')?? '',
            'friday'=>request('friday')?? '',
            'saturday'=>request('saturday')?? '',
            'sunday'=>request('sunday')?? '',
            'public_holiday'=>request('public_holiday')?? '',
            'ABN'=>request('ABN')?? '',
            'establish_year'=>request('establish_year')?? '',
            ]);

        if (!$user) {
           // return $this->responseRedirectBack('Error occurred while updating profile.', 'error', true, true);
           return redirect()->back()->with('failure', 'Error occurred while updating profile');
        }
        //return $this->responseRedirect('business.profile', 'You have successfully updated your profile' ,'success',false, false);
        return redirect()->route('business.profile')->with('success','You have successfully updated your profile');
    }
    //change password
    public function changePassword()
    {
       // dd('here');
        return view('business.changePassword');
    }
    //update password
    public function updatePassword(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|same:new_password|min:6',
        ]);
        $userId = Auth::guard('business')->user()->id;
        $check_old_pass = Auth::guard('business')->attempt(['email' => auth()->guard('business')->user()->email, 'password' => $request->old_password]);

        if (!$check_old_pass) {
            return redirect()->back()->with('failure', 'Old Password is not correct', 'error', true, true);
        }

        $new_pass = Hash::make($request->new_password);
        $user = Directory::findOrFail($userId);
        $user->password =  $new_pass;
        $user->save();
        //Directory::where('email', auth()->guard('business')->email)->update(['password' => $new_pass]);
        if (!$user) {
            return $this->responseRedirectBack('Error occurred while updating Password.', 'error', true, true);
        }else{
        //Auth::guard('business')->logout();
        return redirect()->back()->with('success', 'Password has been updated successfully', 'success', false, false);
        }
    }

    //delete category
    public function deleteCat(Request $request, $dirId, $catId)
    {
        $data = Directory::findOrFail($dirId);

        $newCategoryId = trim(str_replace(','.$catId, '', $data->category_id));

        Directory::where('id', $dirId)->update([
            'category_id' => $newCategoryId
        ]);
        return redirect()->back()->with('success', 'Directory Category removed successfully', 'success', false, false);
        //return $this->responseRedirectBack('Directory Category removed successfully', 'success', false, false);
    }

    public function searchCat(Request $request)
    {
        if (strlen($request->val) > 0) {
            DB::enableQueryLog();
            $data = DirectoryCategory::select('id', 'child_category')->where('child_category', 'like', $request->val.'%')->groupBy('child_category')->limit(10)->get();

            // dd(DB::getQueryLog());

            if (count($data) > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Category found',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Category not found'
                ]);
            }
        }
    }

    public function storeCat(Request $request)
    {
        // dd($request->all());
        $newCategoryIds = implode(',', $request->catId);

        $dirCat = Directory::findOrFail($request->dirId);
        $updatedCat = $dirCat->category_id.$newCategoryIds.',';

        Directory::where('id', $request->dirId)->update([
            'category_id' => $updatedCat
        ]);
        return redirect()->back()->with('success', 'Directory Category added successfully', 'success', false, false);
        //return $this->responseRedirectBack('Directory Category added successfully', 'success', false, false);
    }

    public function twoFacAuthToggle(Request $request) {
        $noti = Directory::findOrFail(Auth::guard('business')->user()->id);
        $noti->is_2fa_enable = $request->check_status;
        $noti->save();
        return redirect()->route('business.profile')->with('success','You have successfully enabled 2FA Authentication');
    }
}
