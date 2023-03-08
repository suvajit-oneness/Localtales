<?php

namespace App\Http\Controllers\Business;

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

    public function index()
    {
        if (!empty($request->pin)||!empty($request->category_id)||!empty($request->keyword)) {
            $pinCode = !empty($request->pin) ? $request->pin : '';
            $categoryId = !empty($request->category_id) ? $request->category_id : '';
            $keyword = !empty($request->keyword) ? $request->keyword : '';
            $deals = $this->dealRepository->searchDealsData($pinCode,$categoryId,$keyword);
        }else{
            $deals = Deal::where('created_by',Auth::guard('business')->user()->id)->paginate(25);
        }

        $categories = DirectoryCategory::where('type',1)->where('status',1)->orderby('parent_category')->get();
        $this->setPageTitle('Deal', 'List of all deals');
        return view('business.deal.index', compact('deals','categories'));
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
        return view('business.deal.create', compact('categories','businesses','state'));
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
            'category_id' => 'required|array',
            'title' => 'required|max:191',
            'address' => 'required|max:191',
            'state' => 'required',
            'pin' => 'required',
            'suburb' => 'required',
            'expiry_date' =>  'required',
            'price' => 'required',
            'promo_code' => 'nullable',
            'discount_type' => 'nullable',
            'discount_amount' => 'nullable',
            'image' => 'required|mimes:jpg,jpeg,png|max:200',
        ]);

        $params = $request->except('_token');
        
        $deal = $this->dealRepository->createDeal($params);

        if (!$deal) {
            return redirect()->back()->with('failure', 'Error occurred while creating deal.', 'error', true, true);
        }
            return redirect()->route('business.deal.index')->with('success', 'Deal has been added successfully' ,'success',false, false);
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
        return view('business.deal.edit', compact('targetDeal','categories','state'));
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

        $deal = $this->dealRepository->updateDeal($params);

        if (!$deal) {
            return redirect()->back()->with('failure', 'Error occurred while updating deal.', 'error', true, true);
        }
        return redirect()->route('business.deal.index')->with('success', 'Deal has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $deal = $this->dealRepository->deleteDeal($id);

        if (!$deal) {
            return redirect()->back()->with('failure', 'Error occurred while deleting deal.', 'error', true, true);
        }
        return redirect()->route('business.deal.index')->with('success', 'Deal has been deleted successfully' ,'success',false, false);
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
        return view('business.deal.details', compact('deal','dealReview'));
    }

    public function startStatus()
    {
        $current_date = date('Y-m-d', strtotime('+1day'));
        $userId = Auth::guard('business')->user()->id;

        $data = Deal::where('created_by', $userId)->where('start_date', $current_date)->where('before_24_hour_notify', 0)->where('status', 1)->get();

        if (count($data) > 0) {
            foreach($data as $deal) {
                $dealUpdate = Deal::findOrFail($deal->id);
                $dealUpdate->before_24_hour_notify = 1;
                $dealUpdate->save();

                // Notify Diretcory about deal starting in 24 hours
                /**
                 * @param int $directoryId
                 * @param string $type
                 * @param object $data
                 */
                directoryNotify($userId, 'deal-starts-in-24-hours', $deal);
            }
        }
    }

    public function endStatus()
    {
        $current_date = date('Y-m-d', strtotime('+1day'));
        $userId = Auth::guard('business')->user()->id;

        $data = Deal::where('created_by', $userId)->where('expiry_date', $current_date)->where('end_before_24_hour_notify', 0)->where('status', 1)->get();

        if (count($data) > 0) {
            foreach($data as $deal) {
                $dealUpdate = Deal::findOrFail($deal->id);
                $dealUpdate->end_before_24_hour_notify = 1;
                $dealUpdate->save();

                // Notify Diretcory about deal starting in 24 hours
                /**
                 * @param int $directoryId
                 * @param string $type
                 * @param object $data
                 */
                directoryNotify($userId, 'deal-ends-in-24-hours', $deal);
            }
        }
    }

    public function afterEndStatus()
    {
        $current_date = date('Y-m-d');
        $userId = Auth::guard('business')->user()->id;

        $data = Deal::where('created_by', $userId)->where('expiry_date', '<', $current_date)->where('deal_end_notify', 0)->where('status', 1)->get();

        if (count($data) > 0) {
            foreach($data as $deal) {
                $dealUpdate = Deal::findOrFail($deal->id);
                $dealUpdate->deal_end_notify = 1;
                $dealUpdate->save();

                // Notify Diretcory about deal starting in 24 hours
                /**
                 * @param int $directoryId
                 * @param string $type
                 * @param object $data
                 */
                directoryNotify($userId, 'deal-expired', $deal);
            }
        }
    }
}
