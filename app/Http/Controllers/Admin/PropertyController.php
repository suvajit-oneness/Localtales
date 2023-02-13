<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\PropertyContract;
use App\Contracts\BusinessContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class PropertyController extends BaseController
{
    /**
     * @var PropertyContract
     */
    protected $propertyRepository;
    /**
     * @var BusinessContract
     */
    protected $businessRepository;


    /**
     * PageController constructor.
     * @param PropertyContract $propertyRepository
     */
    public function __construct(PropertyContract $propertyRepository,BusinessContract $businessRepository)
    {
        $this->propertyRepository = $propertyRepository;
        $this->businessRepository = $businessRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $properties = $this->propertyRepository->listProperties();

        $this->setPageTitle('Property', 'List of all properties');
        return view('admin.property.index', compact('properties'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $businesses = $this->businessRepository->listBusinesss();

        $this->setPageTitle('Property', 'Create Property');
        return view('admin.property.create', compact('businesses'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required|max:191',
            'image'     =>  'required|mimes:jpg,jpeg,png|max:1000',
        ]);

        $params = $request->except('_token');
        
        $property = $this->propertyRepository->createProperty($params);

        if (!$property) {
            return $this->responseRedirectBack('Error occurred while creating property.', 'error', true, true);
        }
        return $this->responseRedirect('admin.property.index', 'Property has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetProperty = $this->propertyRepository->findPropertyById($id);
        $businesses = $this->businessRepository->listBusinesss();
        
        $this->setPageTitle('Property', 'Edit Property : '.$targetProperty->title);
        return view('admin.property.edit', compact('targetProperty','businesses'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required|max:191',
        ]);

        $params = $request->except('_token');

        $property = $this->propertyRepository->updateProperty($params);

        if (!$property) {
            return $this->responseRedirectBack('Error occurred while updating property.', 'error', true, true);
        }
        return $this->responseRedirectBack('Property has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $property = $this->propertyRepository->deleteProperty($id);

        if (!$property) {
            return $this->responseRedirectBack('Error occurred while deleting property.', 'error', true, true);
        }
        return $this->responseRedirect('admin.property.index', 'Property has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $property = $this->propertyRepository->updatePropertyStatus($params);

        if ($property) {
            return response()->json(array('message'=>'Property status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $properties = $this->propertyRepository->detailsProperty($id);
        $property = $properties[0];

        $this->setPageTitle('Property', 'Property Details : '.$property->title);
        return view('admin.property.details', compact('property'));
    }
}
