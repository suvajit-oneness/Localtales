<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Contracts\UserContract;
use Illuminate\Support\Carbon;
use App\Models\Activity;
use App\Models\Notification;
use Illuminate\Http\Response;
class LoginController extends BaseController
{
    use AuthenticatesUsers;
    /**
     * @var UserContract
     */
    protected $userRepository;

    /**
     * Where to redirect user module after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserContract $userRepository)
    {
        $this->middleware('guest:user')->except('logout');
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('site.auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $remember_me = $request->has('remember') ? true : false;

        if (Auth::guard('user')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember_me)) {
            //dd('here');
            $store = new Activity;
            //dd($store);
            $store->user_id =  Auth::guard('user')->user()->id;
            $store->user_type = 'user';
            $store->date = date('Y-m-d H:i:s');
            // $store->slug = null;
            $store->time = Carbon::now();
            $store->type = 'login';
            $ip = $_SERVER['REMOTE_ADDR'];
            $store->location = $ip;
            $store->save();
           // $login=Activity::where('user_id',Auth::guard('user')->user()->id)->where('type','login')->count();
           //$login=$store->count();
           // dd($login);
             if($store->count()==3){
			 // sendNotification('admin', Auth::guard('user')->user()->id, 'update-profile', 'site.dashboard.editProfile','Dear User,If You have not completed your profile elements,Please update');
         	$noti = new Notification();
            $noti->sender_id = 'admin';
            $noti->receiver_id = Auth::guard('user')->user()->id;
            $noti->type =  'update-profile';
            $noti->route = 'site.dashboard.editProfile';
            $noti->title = 'update-profile';
            $noti->description ='Dear User,If You have not completed your profile elements,Please update';
            $noti->read_flag = 0;
            $noti->save();
             }

            return redirect()->intended(route('site.dashboard'))->with('success','login successful');;
        }
        else{
           // return $this->responseRedirectBack('Error occurred while login into account.', 'error', true, true);
            return redirect()->back()->with('failure', 'Email or Password does not match');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        return redirect()->route('index');
    }

    
}
