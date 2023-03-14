<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\PropertyContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Property;
use App\Models\State;
use App\Models\PinCode;
class PropertyController extends BaseController
{
    /**
     * @var PropertyContract
     */
    protected $propertyRepository;

    /**
     * PageController constructor.
     * @param PropertyContract $propertyRepository
     */
    public function __construct(PropertyContract $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        if (!empty($request->term)) {
            $properties = $this->propertyRepository->getSearchProperties($request->term);
        } else {
            $properties = Property::latest('id')->paginate(25);
        }
        $this->setPageTitle('Property', 'List of all properties');
        return view('admin.property.index', compact('properties'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $state=State::orderby('name')->get();
        $pin=PinCode::orderby('pin')->get();
        $this->setPageTitle('Property', 'Create Property');
        return view('admin.property.create',compact('pin','state'));
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
            
        ]);

        $params = $request->except('_token');
        
        $property = $this->propertyRepository->createProperty($params);

        if (!$property) {
            return $this->responseRedirectBack('Error occurred while creating property.', 'error', true, true);
        }
        return $this->responseRedirect('admin.properties.index', 'Property has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetProperty = $this->propertyRepository->findPropertyById($id);
        $state=State::orderby('name')->get();
        $pin=PinCode::orderby('pin')->get();
        $this->setPageTitle('Property', 'Edit Property : '.$targetProperty->title);
        return view('admin.property.edit', compact('targetProperty','pin','state'));
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
        return $this->responseRedirect('admin.properties.index', 'Property has been deleted successfully' ,'success',false, false);
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
