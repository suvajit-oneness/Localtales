<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Contracts\EventContract;
use App\Contracts\CategoryContract;
use App\Contracts\DealContract;
use App\Contracts\BusinessContract;
use App\Contracts\UserContract;
use App\Contracts\NotificationContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\ApplyJob;
use App\Models\Job;
use App\Models\JobUser;
use App\Models\Activity;
use App\Models\Userbusiness;
use App\Models\UserCollection;
use sendNotification;

class UserController extends BaseController
{
    /**
     * @var EventContract
     */
    protected $eventRepository;
	/**
     * @var DealContract
     */
    protected $dealRepository;
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;
    /**
     * @var BusinessContract
     */
    protected $businessRepository;
    /**
     * @var UserContract
     */
    protected $userRepository;
    /**
     * @var NotificationContract
     */
    protected $notificationRepository;

	/**
     * HomeController constructor.
     * @param EventContract $eventRepository
     * @param DealContract $dealRepository
     * @param CategoryContract $categoryRepository
     * @param BusinessContract $businessRepository
     * @param NotificationContract $notificationRepository
     */
    public function __construct(EventContract $eventRepository, DealContract $dealRepository, CategoryContract $categoryRepository, BusinessContract $businessRepository,UserContract $userRepository, NotificationContract $notificationRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->dealRepository = $dealRepository;
        $this->categoryRepository = $categoryRepository;
        $this->businessRepository = $businessRepository;
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
    }

	public function index() {
        $businesses = Userbusiness::where('user_id', Auth::guard('user')->user()->id)->get();
        $collection = UserCollection::where('user_id', Auth::guard('user')->user()->id)->get();

        return view('site.user.dashboard', compact('businesses', 'collection'));
    }

    public function savedCollection() {
        $userId = auth()->guard('user')->user()->id;
        $collection = $this->businessRepository->UserCollection($userId);
        $this->setPageTitle('Saved collection', 'Saved collection');

        return view('site.user.saved-collection', compact('collection'));
    }

    public function savedDirectory() {
        $userId = auth()->guard('user')->user()->id;
        $businesses = $this->businessRepository->UserBusinesses($userId);
        $this->setPageTitle('Saved Directories', 'Saved Directories');

        return view('site.user.saved-directory', compact('businesses'));
    }

    public function savedJob() {
        $userId = auth()->guard('user')->user()->id;
        $jobs = JobUser::where('user_id',$userId)->get();
        $this->setPageTitle('Saved job', 'Saved job');

        return view('site.user.saved-job', compact('jobs'));
    }

    public function allNotifications(){
        $userId = auth()->guard('user')->user()->id;
        $notifications = DB::table('notifications')->where('receiver_id', $userId)->latest('id')->get();

        $this->setPageTitle('Notification List', 'Notification List');
        return view('site.user.notification.index' , compact('notifications'));
    }












      /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function savedEvents(){
        $userId = Auth::user()->id;
        $events = $this->eventRepository->userEvents($userId);

        $this->setPageTitle('Saved Events', 'Saved Events');
        return view('site.dashboard.saved_events' , compact('events'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeSavedEvents($id){
        $userId = Auth::user()->id;
        $event = $this->eventRepository->deleteUserEvent($id,$userId);

        if (!$event) {
            return $this->responseRedirectBack('Error occurred while deleting event.', 'error', true, true);
        }
        return $this->responseRedirect('site.dashboard.saved_events', 'You have successfully removed this event from your list' ,'success',false, false);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function savedDeals(){
        $userId = Auth::user()->id;
        $deals = $this->dealRepository->userDeals($userId);

        $this->setPageTitle('Saved Deals', 'Saved Deals');
        return view('site.dashboard.saved_deals' , compact('deals'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeSavedDeals($id){
        $userId = Auth::user()->id;
        $deal = $this->dealRepository->deleteUserDeal($id,$userId);

        if (!$deal) {
            return $this->responseRedirectBack('Error occurred while deleting deal.', 'error', true, true);
        }
        return $this->responseRedirect('site.dashboard.saved_deals', 'You have successfully removed this deal from your list' ,'success',false, false);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeSavedDirectories($id){
        $userId = Auth::user()->id;
        $business = $this->businessRepository->deleteUserBusiness($id,$userId);

        if (!$business) {
            return $this->responseRedirectBack('Error occurred while deleting directory.', 'error', true, true);
        }
        return $this->responseRedirect('site.dashboard.saved_businesses', 'You have successfully removed this directory from your list' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeSavedCollection($id){
        $userId = Auth::user()->id;
        $ip = $_SERVER['REMOTE_ADDR'];
        $collection = $this->businessRepository->deleteUserCollection($id,$userId,$ip);

        if (!$collection) {
            return $this->responseRedirectBack('Error occurred while deleting collection.', 'error', true, true);
        }
        return $this->responseRedirect('site.dashboard.saved_collection', 'You have successfully removed this directory from your list' ,'success',false, false);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editUserProfile(){
        $this->setPageTitle('Saved Events', 'Saved Events');
        return view('site.auth.edit_profile' );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request){
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
            return $this->responseRedirectBack('Error occurred while updating profile.', 'error', true, true);
        }
        return $this->responseRedirect('site.dashboard.editProfile', 'You have successfully updated your profile' ,'success',false, false);
    }

    
    //save job

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeSavedJob($slug){
        $job=Job::where('slug',$slug)->first();
        // dd($id);
        $userId = auth()->guard('user')->user()->id;
        $ip = $_SERVER['REMOTE_ADDR'];
        $collection = JobUser::where("job_id",$job->id)->where("user_id",$userId)->where("ip",$ip)->delete();
        
       
        if (!$collection) {
            return $this->responseRedirectBack('Error occurred while deleting job.', 'error', true, true);
        }
        return $this->responseRedirectBack('You have successfully removed this job from your list' ,'success',false, false);
    }
    public function appliedJob(){
        $userId = auth()->guard('user')->user()->id;
        $job = ApplyJob::where('user_id',$userId)->get();
        //dd($collection->collectionDetails);
        $this->setPageTitle('Applied job', 'Applied job');
        return view('site.dashboard.applied_jobs' , compact('job'));
    }
}
