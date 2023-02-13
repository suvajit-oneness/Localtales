<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Review;
use App\Models\Order;
use App\Models\Directory;
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
     * Where to redirect business module after login.
     *
     * @var string
     */
    protected $redirectTo = '/business';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:business')->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('business.auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $remember_me = $request->has('remember') ? true : false;
        //dd($remember_me);
        if (Auth::guard('business')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember_me)) {
             //dd('here');
            return redirect()->route('business.dashboard')->with('success','login successful');
        }

        return redirect()->back()->with('failure', 'Email or Password does not match');
        //return response()->json(['error' => true, 'message' => 'No details found. Try again!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout(Request $request)
    {
        Auth::guard('business')->logout();
        $request->session()->invalidate();
        return redirect()->route('business.login');
    }




    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editUserProfile(){
        $this->setPageTitle('Edit Profile', 'Edit Profile');
        $state=State::orderby('name')->get();
        $dircategory=DirectoryCategory::orderby('title')->get();
        return view('business.auth.edit_profile',compact('state','dircategory') );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request){
        dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = Auth::user()->id;
        $params = $request->except('_token');
        $params['id'] = $userId;

        $user = $this->userRepository->updateUser($params);

        if (!$user) {
            return redirect()->back()->with('failure', 'Error occurred while updating profile');
        }
            return redirect()->route('business.profile')->with('success','You have successfully updated your profile');
    }

    public function notificationList(){
        $notifications = $this->notificationRepository->listNotifications();

        $this->setPageTitle('Notification List', 'Notification List');
        return view('business.auth.notifications' , compact('notifications'));
    }

/**
     * This method is for admin dashboard
     *
     */
    public function home(Request $request)
    {
        // $data = $userRepository->listAll();
        // dd($data->count());
        dd('here');
        $data = (object)[];
        $data->review = Review::count();

        $data->localtrade = LocalTradeQueryRequest::count();
        $data->orders = Order::latest('id')->limit(5)->get();
        return view('business.dashboard.index', compact('data'));
    }
    public function changePassword()
    {
        dd('here');
        return view('business.dashboard.changePassword');
    }

    public function updatePassword(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|same:new_password|min:6',
        ]);
        $userId = Auth::guard('business')->user()->id;
        $check_old_pass = Auth::attempt(['email' => auth()->guard('business')->email, 'password' => $request->old_password]);

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

}
