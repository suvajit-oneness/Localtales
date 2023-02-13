<?php

namespace App\Http\Controllers\EventOrganiser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Review;
use App\Models\EventOrganiser;
use App\Models\Event;
use App\Models\State;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\LocalTradeQueryRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;
use App\Models\DirectoryCategory;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * Where to redirect eventorganiser module after login.
     *
     * @var string
     */
    //protected $redirectTo = '/eventorganiser';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:eventorganiser')->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('eventorganiser.auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
         //dd($request->all());
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        //$remember_me = $request->has('remember') ? true : false;
        //$credentials = $request->only('email', 'password');
        //dd($remember_me);
        if (Auth::guard('eventorganiser')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
             //dd('here');
            return redirect()->route('eventorganiser.dashboard')->with('success','login successful');
        }
       else{
           return redirect()->back()->with('failure', 'Email and  Password is not correct', 'error', true, true);
        //return response()->json(['error' => true, 'message' => 'No details found. Try again!']);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout(Request $request)
    {
        Auth::guard('eventorganiser')->logout();
        $request->session()->invalidate();
        return redirect()->route('eventorganiser.login');
    }




    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editUserProfile(){
        $this->setPageTitle('Edit Profile', 'Edit Profile');
        $state=State::orderby('name')->get();
        return view('eventorganiser.auth.edit_profile',compact('state','dircategory') );
    }

     /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profilestore(Request $request){
        dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = Auth::guard('eventorganiser')->user()->id;
        $params = $request->except('_token');
        $params['id'] = $userId;
        if($request->state !=''){
            $address=$request->address.",".$request->suburb.",".$request->state.",".$request->pin;
            }
            else{
            $address=$request->address;
            }
       // dd($address);
        $user=EventOrganiser::where('id',$userId)->update([
            'name'=>request('name'),
            'address'=>$address,
            'email'=>request('email'),
            'mobile'=>request('mobile'),
            'website'=>request('website')?? '',
            'facebook_link'=>request('facebook_link')?? '',
            'twitter_link'=>request('twitter_link')?? '',
            'instagram_link'=>request('instagram_link')?? '',
            ]);

        if (!$user) {
           // return $this->responseRedirectBack('Error occurred while updating profile.', 'error', true, true);
           return redirect()->back()->with('failure', 'Error occurred while updating profile');
        }
        //return $this->responseRedirect('business.profile', 'You have successfully updated your profile' ,'success',false, false);
        return redirect()->route('eventorganiser.profile')->with('success','You have successfully updated your profile');
    }

    public function changePassword()
    {
       dd('here');
        return view('eventorganiser.changePassword');
    }
    public function updatePassword(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|same:new_password|min:6',
        ]);
        $userId = Auth::guard('eventorganiser')->user()->id;
        $check_old_pass = Auth::attempt(['password' => $request->old_password]);

        // if (!$check_old_pass) {
        //     return redirect()->back()->with('success', 'Old Password is not correct', 'error', true, true);
        // }

        $new_pass = Hash::make($request->new_password);

        Directory::where('id',$userId)->update(['password' => $new_pass]);

        //Auth::guard('business')->user()->logout();
        return redirect()->route('eventorganiser.profile')->with('success','You have successfully updated your password');
    }
}
