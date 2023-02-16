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
    public function login()
    {
        return view('business.auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'email' => 'required|email|exists:directories,email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        $remember_me = $request->has('remember') ? true : false;
        if (Auth::guard('business')->attempt($credentials))
        {
            
                if(Auth::guard('business')->user()->is_2fa_enable==1){
                    Auth::guard('business')->user()->generateCode();
    
                    return redirect()->route('2fa.index');
                }else{
                return redirect()->route('business.dashboard')->with('success','login successful');
                }
        }
        else {
           
            return redirect()->route('business.login')->with('failure', 'Wrong credential!');
        }
    }
     /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateCode()
    {
        $code = rand(1000, 9999);
  
        UserCode::updateOrCreate(
            [ 'business_id' => Auth::guard('business')->user()->id ],
            [ 'code' => $code ]
        );
    
        try {
  
            $details = [
                'title' => 'Mail from localtales.com',
                'code' => $code
            ];
             
            Mail::to(auth()->user()->email)->send(new SendCodeMail($details));
    
        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }
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

}
