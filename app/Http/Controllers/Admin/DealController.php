<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\DealContract;
use App\Models\Deal;
use App\Contracts\DirectoryCategoryContract;
use App\Contracts\BussinessLeadContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Auth;
use App\Models\DealReview;
use App\Models\State;
use App\Models\DirectoryCategory;
class DealController extends BaseController
{
    /**
     * @var DealContract
     */
    protected $dealRepository;
    /**
     * @var DirectoryCategoryContract
     */
    protected $DirectoryCategoryRepository;
    /**
     * @var BussinessLeadContract
     */
    protected $BusinessLeadRepository;


    /**
     * NotificationController constructor.
     * @param DealContract $dealRepository
     */
    public function __construct(DealContract $dealRepository,DirectoryCategoryContract $DirectoryCategoryRepository,BussinessLeadContract $BusinessLeadRepository)
    {
        $this->dealRepository = $dealRepository;
        $this->DirectoryCategoryRepository = $DirectoryCategoryRepository;
        $this->BusinessLeadRepository = $BusinessLeadRepository;
        
    }

     /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

     public function index(Request $request)
     {
        if (!empty($request->term)) {
            // dd($request->term);
            $deals = $this->dealRepository->getSearchDeal($request->term);
         }else{
             $deals = Deal::orderby('id','desc')->paginate(25);
         }
         $categories = DirectoryCategory::where('type',1)->where('status',1)->orderby('parent_category')->get();
         $this->setPageTitle('Deal', 'List of all deals');
         return view('admin.deal.index', compact('deals','categories'));
     }
     
     /**
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
     public function create()
     {
         $categories = $this->dealRepository->listCategories();
         $businesses = $this->BusinessLeadRepository->listBusinesssLead();
         $state=State::orderby('name')->get();
         $this->setPageTitle('Deal', 'Create Deal');
         return view('admin.deal.create', compact('categories','businesses','state'));
     }
 
     /**
      * @param Request $request
      * @return \Illuminate\Http\RedirectResponse
      * @throws \Illuminate\Validation\ValidationException
      */
     public function store(Request $request)
     {
         //dd($request->all());
         $this->validate($request, [
             'category_id'      =>  'required',
             'directory_id'      =>  'required',
             'title'      =>  'required|max:191',
             'address'      =>  'required|max:191',
             'state'      =>  'required',
             'pin'      =>  'required',
             'suburb'      =>  'required',
             'expiry_date'      =>  'required',
             'price'      =>  'required',
             'promo_code'      =>  'nullable',
             'discount_type'      =>  'nullable',
             'discount_amount'      =>  'nullable',
             'image'     =>  'required|mimes:jpg,jpeg,png|max:2000',
         ]);
 
         $params = $request->except('_token');
         
         $deal = $this->dealRepository->createDealAdmin($params);
 
         if (!$deal) {
            return $this->responseRedirectBack('Error occurred while creating deal.', 'error', true, true);
         }
         return $this->responseRedirect('admin.deal.index', 'Deal has been added successfully' ,'success',false, false);
         
     }
 
     /**
      * @param $id
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
     public function edit($id)
     {
         $targetDeal = $this->dealRepository->findDealById($id);
         $categories = $this->dealRepository->listCategories();
         //$businesses = $this->businessRepository->listBusinesss();
         $state=State::orderby('name')->get();
         $this->setPageTitle('Deal', 'Edit Deal : '.$targetDeal->title);
         return view('admin.deal.edit', compact('targetDeal','categories','state'));
     }
 
     /**
      * @param Request $request
      * @return \Illuminate\Http\RedirectResponse
      * @throws \Illuminate\Validation\ValidationException
      */
     public function update(Request $request)
     {
         //dd($request->all());
         $this->validate($request, [
             'category_id'      =>  'nullable',
             'directory_id'      =>  'nullable',
             'title'      =>  'required|max:191',
             'address'      =>  'required|max:191',
             'state'      =>  'nullable',
             'pin'      =>  'nullable',
             'suburb'      =>  'nullable',
             'expiry_date'      =>  'required',
             'price'      =>  'required',
             'promo_code'      =>  'nullable',
             'discount_type'      =>  'nullable',
             'discount_amount'      =>  'nullable',
             'image'     =>  'nullable|mimes:jpg,jpeg,png|max:2000',
         ]);
 
         $params = $request->except('_token');
 
         $deal = $this->dealRepository->updateDealAdmin($params);
 
         if (!$deal) {
            return $this->responseRedirectBack('Error occurred while updating deal.', 'error', true, true);
         }
         return $this->responseRedirect('admin.deal.index', 'Deal has been updated successfully' ,'success',false, false);
     }
 
     /**
      * @param $id
      * @return \Illuminate\Http\RedirectResponse
      */
     public function delete($id)
     {
         $deal = $this->dealRepository->deleteDeal($id);
 
         if (!$deal) {
            return $this->responseRedirectBack('Error occurred while deleting deal.', 'error', true, true);
        }
        return $this->responseRedirect('admin.deal.index', 'deal has been deleted successfully', 'success', false, false);
    }
 
     /**
      * @param Request $request
      * @return \Illuminate\Http\RedirectResponse
      * @throws \Illuminate\Validation\ValidationException
      */
     public function updateStatus(Request $request){
 
         $params = $request->except('_token');
 
         $deal = $this->dealRepository->updateDealStatus($params);
 
         if ($deal) {
             return response()->json(array('message'=>'Deal status has been successfully updated'));
         }
     }
 
     /**
      * @param $id
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
     public function details($id)
     {
         $deals = $this->dealRepository->detailsDeal($id);
         $deal = $deals[0];
         $dealReview=DealReview::where('deal_id',$deal->id)->get();
 
         $this->setPageTitle('Deal', 'Deal Details : '.$deal->title);
         return view('admin.deal.details', compact('deal','dealReview'));
     }
}
