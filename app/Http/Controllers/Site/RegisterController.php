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

class RegisterController extends Controller
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
    public function register(){
        return view('site.auth.register' );
    }

    /**
     * This method is for user registration
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|digits:10',
            'password' => 'required|string|min:6',
        ]);

       /* if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }*/

        $params = $request->except('_token');

        $user = $this->userRepository->createUser($params);

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while creating account.', 'error', true, true);
        }
        $remember_me = $request->has('remember') ? true : false;

        if (Auth::guard('user')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember_me)) {
            return redirect()->intended(route('site.dashboard'))->with('success','Your account has been added successfully');;
        }
    }
}
