<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\PincodeContract;
use App\Models\PinCode;
use App\Models\ActivityLogCsv;
use Session;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PinCodeExport;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Session as FacadesSession;

class PinCodeManagementController extends BaseController
{
    protected $PincodeRepository;

    /**
     * StateManagementController constructor.
     * @param PincodeRepository $StateRepository
     */

    public function __construct(PincodeContract $PincodeRepository)
    {
        $this->PincodeRepository = $PincodeRepository;
    }

    /**
     * List all the states
     */
    public function index(Request $request)
    {
        $data =  PinCode::paginate(20);
        if (!empty($request->term)) {
            // dd($request->term);
            $pin = $this->PincodeRepository->getSearchpin($request->term);

            // dd($categories);
        } else {
            $pin = PinCode::paginate(20);
        }
        $this->setPageTitle('Postcode', 'List of all Postcode');
        $states = $this->PincodeRepository->getAllState();
        return view('admin.pin.index', compact('pin', 'states', 'data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Postcode', 'Create Postcode');
        $states = $this->PincodeRepository->getAllState();
        return view('admin.pin.create', compact('states'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pin'      =>  'required|max:191',
            "state_id" => "required|integer",
            "image" => "required|mimes:jpeg,png"
        ]);

        $params = $request->except('_token');

        $name = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path() . '/admin/uploads/pincode/images/', $name);

        $params['image'] = $name;

        $state = $this->PincodeRepository->createPincode($params);

        if (!$state) {
            return $this->responseRedirectBack('Error occurred while creating Postcode.', 'error', true, true);
        }
        return $this->responseRedirect('admin.pin.index', 'Postcode has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetpin = $this->PincodeRepository->findPincodeById($id);

        $this->setPageTitle('Postcode', 'Edit Postcode : ' . $targetpin->pin);
        $states = $this->PincodeRepository->getAllState();
        return view('admin.pin.edit', compact('targetpin', 'states'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'pin'      =>  'required|max:191',
            "state_id" => "required|integer",
        ]);

        $params = $request->except('_token');

        if ($request->image) {
            $params['image'] = uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path() . '/admin/uploads/pincode/images/', $params['image']);
        }

        $targetpin = $this->PincodeRepository->updatePincode($params);

        if (!$targetpin) {
            return $this->responseRedirectBack('Error occurred while updating Postcode.', 'error', true, true);
        }
        return $this->responseRedirectBack('Postcode has been updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $targetpin = $this->PincodeRepository->deletePincode($id);

        if (!$targetpin) {
            return $this->responseRedirectBack('Error occurred while deleting Postcode.', 'error', true, true);
        }
        return $this->responseRedirect('admin.pin.index', 'Postcode has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $targetpin = $this->PincodeRepository->updatePincodeStatus($params);

        if ($targetpin) {
            return response()->json(array('message' => 'Postcode status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetpin = $this->PincodeRepository->detailsPincode($id);
        $pin = $targetpin[0];

        $this->setPageTitle('Postcode', 'Postcode Details : ' . $pin->pin);
        return view('admin.pin.details', compact('pin'));
    }



    public function csvStore(Request $request)
    {
        // dd($request->all());

        try {
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
                        $location = 'admin/uploads/pincode/csv';
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
                            // dd($num);
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

                        $insertData = [];
                        $count = $total = 0;
                        $successArr = $failureArr = [];

                        // Insert into database
                        foreach ($importData_arr as $importData) {
                            // $storeData = 0;
                            // if(isset($importData[2]) == "Carry In") $storeData = 1;

                            $insertData = array(
                                "pin" => isset($importData[0]) ? $importData[0] : null,
                                "description" => isset($importData[1]) ? $importData[1] : null,
                                "image" => isset($importData[2]) ? $importData[2] : null
                            );
                            // echo '<pre>';print_r($insertData);exit();
                            $resp = PinCode::insertData($insertData, $count, $successArr, $failureArr);
                            $count = $resp['count'];
                            $successArr = $resp['successArr'];
                            $failureArr = $resp['failureArr'];
                            $total++;
                        }

                        // dd($resp);

                        $store = new ActivityLogCsv;
                        $store->user_id =  Auth::guard('admin')->user()->id;
                        $store->csv_file_location = $location . "/" . $filename;
                        $store->total_rows = $total;
                        $store->success_count = $count;
                        $store->success_array = (count($resp['successArr']) > 0) ? json_encode($resp['successArr']) : '';
                        $store->failure_count = $total - $count;
                        $store->failure_array = (count($resp['failureArr']) > 0) ? json_encode($resp['failureArr']) : '';
                        $store->csv_type = 'postcode';
                        $store->save();

                        if($count == 0){
                            FacadesSession::flash('csv', 'Already Uploaded. ');
                        } else{
                             FacadesSession::flash('csv', 'Import Successful. '.$count.' Data Uploaded');
                        }
                        //return redirect()->back()->with('message', 'Import Successful.');
                    } else {
                        FacadesSession::flash('message', 'File too large. File must be less than 50MB.');
                    }
                } else {
                    FacadesSession::flash('message', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
                }
            } else {
                FacadesSession::flash('message', 'No file found.');
            }

            return redirect()->route('admin.pin.index');
        } catch (\Exception $th) {
            return $th;
        }
    }



    public function export()
    {
        return Excel::download(new PinCodeExport, 'postcode.xlsx');
    }
    // csv upload

    public function upload_bulk_images(Request $request)
    {
        foreach ($request->image as $image) {
            $name = $image->getClientOriginalName();
            $image->move(public_path() . '/admin/uploads/pincode/images/', $name);
        }
        FacadesSession::flash('image_uploaded', 'All images imported Successfully.');
        return redirect()->back();
    }
}
