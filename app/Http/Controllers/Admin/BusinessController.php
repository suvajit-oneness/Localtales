<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\BusinessContract;
use App\Contracts\CategoryContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class BusinessController extends BaseController
{
    /**
     * @var BusinessContract
     */
    protected $businessRepository;
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;


    /**
     * BusinessController constructor.
     * @param BusinessContract $businessRepository
     * @param CategoryContract $categoryRepository
     */
    public function __construct(BusinessContract $businessRepository, CategoryContract $categoryRepository)
    {
        $this->businessRepository = $businessRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $businesses = $this->businessRepository->listBusinesss();

        $this->setPageTitle('Business', 'List of all businesses');
        return view('admin.business.index', compact('businesses'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->categoryRepository->listCategories();

        $this->setPageTitle('Business', 'Create Business');
        return view('admin.business.create',compact('categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'email'     =>  'required|max:1000',
        ]);

        $params = $request->except('_token');
        
        $business = $this->businessRepository->createBusiness($params);

        if (!$business) {
            return $this->responseRedirectBack('Error occurred while creating business.', 'error', true, true);
        }
        return $this->responseRedirect('admin.business.index', 'Business added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $categories = $this->categoryRepository->listCategories();
        $targetBusiness = $this->businessRepository->findBusinessById($id);
        
        $this->setPageTitle('Business', 'Edit Business : '.$targetBusiness->title);
        return view('admin.business.edit', compact('targetBusiness','categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
        ]);

        $params = $request->except('_token');

        $business = $this->businessRepository->updateBusiness($params);

        if (!$business) {
            return $this->responseRedirectBack('Error occurred while updating business.', 'error', true, true);
        }
        return $this->responseRedirectBack('Business updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $business = $this->businessRepository->deleteBusiness($id);

        if (!$business) {
            return $this->responseRedirectBack('Error occurred while deleting business.', 'error', true, true);
        }
        return $this->responseRedirect('admin.business.index', 'Business deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $business = $this->businessRepository->updateBusinessStatus($params);

        if ($business) {
            return response()->json(array('message'=>'Business status successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $businesses = $this->businessRepository->detailsBusiness($id);
        $business = $businesses[0];
        
        $this->setPageTitle('Business', 'Business Details : '.$business->title);
        return view('admin.business.details', compact('business'));
    }
}
