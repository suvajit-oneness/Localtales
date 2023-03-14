<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\DoctorContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\DoctorHospital;
use App\Models\State;
use App\Models\PinCode;


class DoctorController extends BaseController
{
     /**
     * @var DoctorContract
     */
    protected $DoctorRepository;

    /**
     * PageController constructor.
     * @param DoctorContract $DoctorRepository
     */
    public function __construct(DoctorContract $DoctorRepository)
    {
        $this->DoctorRepository = $DoctorRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        if (!empty($request->term)) {
            $doctors = $this->DoctorRepository->getSearchDoctor($request->term);
        } else {
            $doctors = DoctorHospital::latest('id')->paginate(25);
        }
        $this->setPageTitle('Doctor/Hospital', 'List of all Doctor/Hospital');
        return view('admin.doctor.index', compact('doctors'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $state=State::orderby('name')->get();
        $pin=PinCode::orderby('pin')->get();
        $this->setPageTitle('Doctor/Hospital', 'Create Doctor/Hospital');
        return view('admin.doctor.create',compact('pin','state'));
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
        
        $data = $this->DoctorRepository->createDoctor($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating Doctor/Hospital.', 'error', true, true);
        }
        return $this->responseRedirect('admin.doctor.index', 'Doctor/Hospital has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetDoctor = $this->DoctorRepository->findDoctorById($id);
        $state=State::orderby('name')->get();
        $pin=PinCode::orderby('pin')->get();
        $this->setPageTitle('Doctor/Hospital', 'Edit Doctor/Hospital : '.$targetDoctor->title);
        return view('admin.doctor.edit', compact('targetDoctor','pin','state'));
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

        $school = $this->DoctorRepository->updateDoctor($params);

        if (!$school) {
            return $this->responseRedirectBack('Error occurred while updating Doctor/Hospital.', 'error', true, true);
        }
        return $this->responseRedirectBack('Doctor/Hospital has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $school = $this->DoctorRepository->deleteDoctor($id);

        if (!$school) {
            return $this->responseRedirectBack('Error occurred while deleting Doctor/Hospital.', 'error', true, true);
        }
        return $this->responseRedirect('admin.doctor.index', 'Doctor/Hospital has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $school = $this->DoctorRepository->updateDoctorStatus($params);

        if ($school) {
            return response()->json(array('message'=>'Doctor/Hospital status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $School = $this->DoctorRepository->detailsDoctor($id);
        $data = $School[0];

        $this->setPageTitle('Doctor/Hospital', 'Doctor/Hospital Details : '.$data->title);
        return view('admin.doctor.details', compact('data'));
    }
}
