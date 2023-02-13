<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\DealContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Auth;

class DealController extends BaseController
{
    /**
     * @var DealContract
     */
    protected $dealRepository;


    /**
     * DealController constructor.
     * @param DealContract $dealRepository
     */
    public function __construct(DealContract $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    /**
     * This method is for getting deals pin code wise
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3000';
        $deals = $this->dealRepository->getDealsByPinCode($pinCode);

        return response()->json(compact('deals'));
    }

    /**
     * This method is for getting deal details
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function details($id){
        $deals = $this->dealRepository->detailsDeal($id);
        $deal = $deals[0];

        $related_deals = $this->dealRepository->getRelatedDeals($deal->pin,$id);

        return response()->json(compact('deals','related_deals'));
    }

    /**
     * This method is to filter deal data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request){
        $pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3000';
        $categoryId = (isset($request->category_id) && $request->category_id!='')?$request->category_id:'';
        $keyword = (isset($request->keyword) && $request->keyword!='')?$request->keyword:'';

        $deals = $this->dealRepository->searchDealsData($pinCode,$categoryId,$keyword);
        
        return response()->json(compact('deals'));
    }

    /**
     * This method is to get category wise deals data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryWiseDeals(Request $request){
        $pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3000';
        $categoryId = (isset($request->category_id) && $request->category_id!='')?$request->category_id:'';

        $deals = $this->dealRepository->getDealsByCategory($pinCode,$categoryId);
        
        return response()->json(compact('deals'));
    }

    /**
     * This method is to save user deal
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveUserDeal(Request $request){
        $deal_id = $request->deal_id;
        $user_id = $request->user_id;

        $this->dealRepository->saveUserDeal($deal_id,$user_id);

        $data['message'] = "You have saved this deal";

        return response()->json(compact('data'));
    }

    /**
     * This method is to delete user deal
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserDeal(Request $request){
        $deal_id = $request->deal_id;
        $user_id = $request->user_id;

        $this->dealRepository->deleteUserDeal($deal_id,$user_id);

        $data['message'] = "You have removed this deal from your list";

        return response()->json(compact('data'));
    }

    /**
     * This method is to check user deal exists
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUserDeals(Request $request){
        $deal_id = $request->deal_id;
        $user_id = $request->user_id;

        $userDeals = $this->dealRepository->checkUserDeals($deal_id,$user_id);

        return response()->json(compact('userDeals'));
    }
}