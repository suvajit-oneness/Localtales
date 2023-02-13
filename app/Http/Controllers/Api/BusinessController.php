<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\BusinessContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Auth;

class BusinessController extends BaseController
{
    /**
     * @var BusinessContract
     */
    protected $businessRepository;


    /**
     * BusinessController constructor.
     * @param BusinessContract $businessRepository
     */
    public function __construct(BusinessContract $businessRepository)
    {
        $this->businessRepository = $businessRepository;
    }

    /**
     * This method is for getting directories pin code wise
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3000';
        $directories = $this->businessRepository->getBusinessByPinCode($pinCode);

        return response()->json(compact('directories'));
    }

    /**
     * This method is for getting directory details
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function details($id){
        $directories = $this->businessRepository->detailsBusiness($id);
        $directory = $directories[0];

        return response()->json(compact('directory'));
    }

    /**
     * This method is to get category wise directories data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryWiseBusiness(Request $request){
        $pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3000';
        $categoryId = (isset($request->category_id) && $request->category_id!='')?$request->category_id:'';

        $directories = $this->businessRepository->getBusinessByCategory($pinCode,$categoryId);
        
        return response()->json(compact('directories'));
    }

    /**
     * This method is to save user business
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveUserBusiness(Request $request){
        $business_id = $request->business_id;
        $user_id = $request->user_id;

        $this->businessRepository->saveUserBusiness($business_id,$user_id);

        $data['message'] = "You have saved this directory";

        return response()->json(compact('data'));
    }

    /**
     * This method is to delete user business
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserBusiness(Request $request){
        $business_id = $request->business_id;
        $user_id = $request->user_id;

        $this->businessRepository->deleteUserBusiness($business_id,$user_id);

        $data['message'] = "You have removed this directory from your list";

        return response()->json(compact('data'));
    }

    /**
     * This method is to check user business exists
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUserBusinesses(Request $request){
        $business_id = $request->business_id;
        $user_id = $request->user_id;

        $userBusinesses = $this->businessRepository->checkUserBusinesses($business_id,$user_id);

        return response()->json(compact('userBusinesses'));
    }
}