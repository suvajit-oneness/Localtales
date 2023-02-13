<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\JobEmploymentTypeContract;
use Illuminate\Http\Request;
use App\Models\JobEmploymentType;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JobTypeExport;
use Illuminate\Support\Facades\Session as FacadesSession;
class JobEmploymentTypeController extends BaseController
{
    /**
     * @var JobTypeContract
     */
    protected $JobEmploymentTypeRepository;


    /**
     * JobEmploymentTypeController constructor.
     * @param JobEmploymentTypeContract $JobEmploymentTypeRepository
     */
    public function __construct(JobEmploymentTypeContract $JobEmploymentTypeRepository)
    {
        $this->JobEmploymentTypeRepository = $JobEmploymentTypeRepository;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        if (!empty($request->term)) {
            $type = $this->JobEmploymentTypeRepository->getSearchtype($request->term);
        } else {
            $type = JobEmploymentType::orderby('title')->paginate(25);
        }
        $this->setPageTitle('Employment Type', 'Employment Type');
        return view('admin.jobtype.index', compact('type'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Employment Type', 'Create Employment Type');
        return view('admin.jobtype.create');
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

        $Type = $this->JobEmploymentTypeRepository->createType($params);

        if (!$Type) {
            return $this->responseRedirectBack('Error occurred while creating Employment Type.', 'error', true, true);
        }
        return $this->responseRedirect('admin.job.type.index', 'Employment Type has been created successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $type = $this->JobEmploymentTypeRepository->findTypeById($id);
        $this->setPageTitle('Employment Type', 'Edit Employment Type : '.$type->title);
        return view('admin.jobtype.edit', compact('type'));
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
        $Type = $this->JobEmploymentTypeRepository->updateType($params);
        if (!$Type) {
            return $this->responseRedirectBack('Error occurred while updating  Employment Type.', 'error', true, true);
        }
        return $this->responseRedirectBack('Employment Type has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $Type = $this->JobEmploymentTypeRepository->deleteType($id);

        if (!$Type) {
            return $this->responseRedirectBack('Error occurred while deleting Employment Type.', 'error', true, true);
        }
        return $this->responseRedirect('admin.job.Type.index', 'Employment Type has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $Type = $this->JobEmploymentTypeRepository->updateTypeStatus($params);

        if ($Type) {
            return response()->json(array('message'=>'Employment Type status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $Type = $this->JobEmploymentTypeRepository->detailsType($id);
        $type = $Type[0];
        $this->setPageTitle('Employment Type', 'Employment Type Details : '.$type->title);
        return view('admin.jobtype.details', compact('type'));
    }


    public function csvStore(Request $request)
    {
        if (!empty($request->file)) {
            // if ($request->input('submit') != null ) {
            $file = $request->file('file');
            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Valid File Extensions
            $valid_extension = array("csv");
            // 50MB in Bytes
            $maxFileSize = 50097152;
            // Check file extension
            if (in_array(strtolower($extension), $valid_extension)) {
                // Check file size
                if ($fileSize <= $maxFileSize) {
                    // File upload location
                    $location = 'admin/uploads/csv';
                    // Upload file
                    $file->move($location, $filename);
                    // Import CSV to Database
                    $filepath = public_path($location . "/" . $filename);
                    // Reading file
                    $file = fopen($filepath, "r");
                    $importData_arr = array();
                    $i = 0;
                    while (($filedata = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $num = count($filedata);
                        // Skip first row
                        if ($i == 0) {
                            $i++;
                            continue;
                        }
                        for ($c = 0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata[$c];
                        }
                        $i++;
                    }
                    fclose($file);
                    $insertData = [];
                    $count = $total = 0;
                    $successArr = $failureArr = [];
                    // echo '<pre>';print_r($importData_arr);exit();

                    // Insert into database
                    if (!empty($importData[0])) {
                        // dd($importData[0]);
                        $titleArr = explode(',', $importData[0]);

                        // echo '<pre>';print_r($titleArr);exit();

                        foreach ($titleArr as $titleKey => $titleValue) {
                            // slug generate
                            $slug = Str::slug($titleValue, '-');
                            $slugExistCount = DB::table('job_type')->where('title', $titleValue)->count();
                            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

                        $insertData = array(
                            "title" => isset($importData[0]) ? $importData[0] : null,
                            "slug" => $slug,
                            "description" => isset($importData[1]) ? $importData[1] : null,

                        );
                        // echo '<pre>';print_r($insertData);exit();
                        $resp = JobType::insertData($insertData, $count, $successArr, $failureArr);
                    }
                }
                if($count == 0){
                    FacadesSession::flash('csv', 'Already Uploaded. ');
                } else{
                     FacadesSession::flash('csv', 'Import Successful. '.$count.' Data Uploaded');
                }
                    //Session::flash('message', 'Import Successful.');
                } else {
                    Session::flash('message', 'File too large. File must be less than 50MB.');
                }
            } else {
                Session::flash('message', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
            }
        } else {
            Session::flash('message', 'No file found.');
        }
        return redirect()->route('admin.job.Type.index');
    }

     // export
     public function export()
     {
         return Excel::download(new JobTypeExport, 'JobType.xlsx');
     }
}

