<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\User;
use App\Contracts\StateContract;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;
use App\Models\ActivityLogCsv;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StateExport;
use Illuminate\Support\Facades\Session as FacadesSession;

class StateManagementController extends BaseController
{
    protected $StateRepository;

    /**
     * StateManagementController constructor.
     * @param StateRepository $StateRepository
     */

    public function __construct(StateContract $StateRepository)
    {
        $this->StateRepository = $StateRepository;
    }

    /**
     * List all the states
     */
    public function index(Request $request)
    {
        $data =  State::paginate(5);
        if (!empty($request->term)) {
            // dd($request->term);
            $states = $this->StateRepository->getSearchState($request->term);

            // dd($categories);
        } else {
            $states = State::paginate(5);
        }
        $this->setPageTitle('State', 'List of all state');
        return view('admin.state.index', compact('states', 'data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('State', 'Create State');
        return view('admin.state.create');
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
            'image' => 'required|mimes:jpeg,png'
        ]);
        $slug = Str::slug($request->name, '-');
        $slugExistCount = State::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

        // send slug
        request()->merge(['slug' => $slug]);

        $params = $request->except('_token');

        if ($request->image) {
            $params['image'] = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path() . '/admin/uploads/state/images/', $params['image']);
        }

        $state = $this->StateRepository->createState($params);

        if (!$state) {
            return $this->responseRedirectBack('Error occurred while creating state.', 'error', true, true);
        }
        return $this->responseRedirect('admin.state.index', 'State has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetstate = $this->StateRepository->findStateById($id);

        $this->setPageTitle('State', 'Edit State : ' . $targetstate->title);
        return view('admin.state.edit', compact('targetstate'));
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
        $slug = Str::slug($request->name, '-');
        $slugExistCount = State::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
        $params = $request->except('_token');

        if ($request->image) {
            $params['image'] = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path() . '/admin/uploads/state/images/', $params['image']);
        }

        $targetstate = $this->StateRepository->updateState($params);

        if (!$targetstate) {
            return $this->responseRedirectBack('Error occurred while updating state.', 'error', true, true);
        }
        return $this->responseRedirectBack('State has been updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $targetstate = $this->StateRepository->deleteState($id);

        if (!$targetstate) {
            return $this->responseRedirectBack('Error occurred while deleting State.', 'error', true, true);
        }
        return $this->responseRedirect('admin.state.index', 'State has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $targetstate = $this->StateRepository->updateStateStatus($params);

        if ($targetstate) {
            return response()->json(array('message' => 'State status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetstate = $this->StateRepository->detailsState($id);
        $state = $targetstate[0];

        $this->setPageTitle('State', 'Category Details : ' . $state->name);
        return view('admin.state.details', compact('state'));
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

                    // echo '<pre>';print_r($importData_arr);exit();
                        $count = $total = 0;
                        $successArr = $failureArr = [];
                    // Insert into database
                    foreach ($importData_arr as $importData) {
                        $storeData = 0;
                        if (isset($importData[5]) == "Carry In") $storeData = 1;

                        $insertData = array(
                            "name" => isset($importData[0]) ? $importData[0] : null,
                            "slug" => isset($importData[0]) ? $importData[0] : null,
                            "image" => isset($importData[1]) ? $importData[1] : null,
                        );
                        // echo '<pre>';print_r($insertData);exit();
                         $resp = State::insertData($insertData ,$count,$successArr,$failureArr);
                         $count = $resp['count'];
                        $successArr = $resp['successArr'];
                        $failureArr = $resp['failureArr'];
                        $total++;
                    }
                        $store = new ActivityLogCsv;
                        $store->user_id =  Auth::guard('admin')->user()->id;
                        $store->csv_file_location = $location . "/" . $filename;
                        $store->total_rows = $total;
                        $store->success_count = $count;
                        $store->success_array = (count($resp['successArr']) > 0) ? json_encode($resp['successArr']) : '';
                        $store->failure_count = $total - $count;
                        $store->failure_array = (count($resp['failureArr']) > 0) ? json_encode($resp['failureArr']) : '';
                        $store->csv_type = 'state';
                        $store->save();
                    //Session::flash('message', 'Import Successful.');
                     if($count==0){
                            FacadesSession::flash('csv', 'Already Uploaded. ');
                        }
                        else{
                             FacadesSession::flash('csv', 'Import Successful. '.$count.' Data Uploaded');
                        }
                } else {
                    Session::flash('message', 'File too large. File must be less than 50MB.');
                }
            } else {
                Session::flash('message', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
            }
        } else {
            Session::flash('message', 'No file found.');
        }
        return redirect()->route('admin.state.index');
    }

    public function export()
    {
        return Excel::download(new StateExport, 'state.xlsx');
    }

    public function upload_bulk_images(Request $request)
    {
        foreach ($request->image as $image) {
            $name = $image->getClientOriginalName();
            $image->move(public_path() . '/admin/uploads/state/images/', $name);
        }
        FacadesSession::flash('image_uploaded', 'All images imported Successfully.');
        return redirect()->back();
    }
}
