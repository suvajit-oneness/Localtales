<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\SchoolContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\School;
use App\Models\State;
use App\Models\PinCode;

class SchoolController extends BaseController
{
    /**
     * @var SchoolContract
     */
    protected $NewsRepository;

    /**
     * PageController constructor.
     * @param SchoolContract $SchoolRepository
     */
    public function __construct(SchoolContract $SchoolRepository)
    {
        $this->SchoolRepository = $SchoolRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        if (!empty($request->term)) {
            $schools = $this->SchoolRepository->getSearchSchool($request->term);
        } else {
            $schools = School::latest('id')->paginate(25);
        }
        $this->setPageTitle('School', 'List of all School');
        return view('admin.school.index', compact('schools'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $state=State::orderby('name')->get();
        $pin=PinCode::orderby('pin')->get();
        $this->setPageTitle('News', 'Create News');
        return view('admin.school.create',compact('pin','state'));
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
        
        $data = $this->SchoolRepository->createSchool($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating School.', 'error', true, true);
        }
        return $this->responseRedirect('admin.school.index', 'School has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetSchool = $this->SchoolRepository->findSchoolById($id);
        $state=State::orderby('name')->get();
        $pin=PinCode::orderby('pin')->get();
        $this->setPageTitle('School', 'Edit School : '.$targetSchool->title);
        return view('admin.school.edit', compact('targetSchool','pin','state'));
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

        $school = $this->SchoolRepository->updateSchool($params);

        if (!$school) {
            return $this->responseRedirectBack('Error occurred while updating School.', 'error', true, true);
        }
        return $this->responseRedirectBack('School has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $school = $this->SchoolRepository->deleteSchool($id);

        if (!$school) {
            return $this->responseRedirectBack('Error occurred while deleting School.', 'error', true, true);
        }
        return $this->responseRedirect('admin.school.index', 'School has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $school = $this->SchoolRepository->updateSchoolStatus($params);

        if ($school) {
            return response()->json(array('message'=>'School status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $School = $this->SchoolRepository->detailsSchool($id);
        $data = $School[0];

        $this->setPageTitle('School', 'School Details : '.$data->title);
        return view('admin.school.details', compact('data'));
    }
}
