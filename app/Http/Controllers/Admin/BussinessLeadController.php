<?php

namespace App\Http\Controllers\Admin;

use App\BusinessLeads;
use App\Http\Controllers\Controller;
use App\Contracts\BussinessLeadContract;
use App\Models\BusinessLead;
use App\Models\BusinessSignupPage;
use App\Models\DirectoryCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class BussinessLeadController extends BaseController
{
    /**
     * @var BusinessContract
     */
    protected $BusinessLeadRepository;



    /**
     * BusinessController constructor.
     * @param BusinessContract $BusinessLeadRepository
     * @param CategoryContract $categoryRepository
     */
    public function __construct(BussinessLeadContract $BusinessLeadRepository)
    {
        $this->BusinessLeadRepository = $BusinessLeadRepository;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        $data =  BusinessLead::paginate(5);
        if (!empty($request->term)) {
            // dd($request->term);
             $businesses = $this->BusinessLeadRepository->getSearchBussiness($request->term);

            // dd($categories);
         } else {
        $businesses = $this->BusinessLeadRepository->listBusinesssLead();
         }
        $this->setPageTitle('Business Lead', 'List of all businesses');
        return view('admin.bussinesslead.index', compact('businesses','data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $directoryCategories = DirectoryCategory::all();
        $this->setPageTitle('Business Lead', 'Create Business');
        return view('admin.bussinesslead.create', compact('directoryCategories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'bussiness_name' => 'required|string|min:1',
            'category' => 'nullable|integer|min:1',
            'service_description' => 'nullable|string|min:1',
            'description' => 'nullable|string|min:1',
            'email' => 'nullable|string|min:1',
            'mobile_no' => 'nullable|string|min:1',
            'alt_mobile_no' => 'nullable|string|min:1',
            'facebook_link' => 'nullable|string',
            'twitter_link' => 'nullable|string',
            'instagram_link' => 'nullable|string',
            'linkedin_link' => 'nullable|string',
            'youtube_link' => 'nullable|string',
            'bussiness_address' => 'nullable|string',
            'monday_opening_hour' => 'nullable|string',
            'tuesday_opening_hour' => 'nullable|string',
            'wednesday_opening_hour' => 'nullable|string',
            'thursday_opening_hour' => 'nullable|string',
            'friday_opening_hour' => 'nullable|string',
            'saturday_opening_hour' => 'nullable|string',
            'sunday_opening_hour' => 'nullable|string',
            'type' =>'nullable|string',
        ]);

        $params = $request->except('_token');

        $business = $this->BusinessLeadRepository->createLeadBusiness($params);

        if (!$business) {
            return $this->responseRedirectBack('Error occurred while creating business lead.', 'error', true, true);
        }
        return $this->responseRedirect('admin.bussinesslead.index', 'Business Lead added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {

        $targetBusiness = $this->BusinessLeadRepository->findBusinessLeadById($id);
        $directoryCategories = DirectoryCategory::all();

        $this->setPageTitle('Business Lead', 'Edit Business Lead : '.$targetBusiness->bussiness_name);
        return view('admin.bussinesslead.edit', compact('targetBusiness', 'directoryCategories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $request->validate([
            'bussiness_name' => 'required|string|min:1',
            'category' => 'nullable|integer|min:1',
            'service_description' => 'nullable|string|min:1',
            'description' => 'nullable|string|min:1',
            'email' => 'nullable|string|min:1',
            'mobile_no' => 'nullable|string|min:1',
            'alt_mobile_no' => 'nullable|string|min:1',
            'facebook_link' => 'nullable|string',
            'twitter_link' => 'nullable|string',
            'instagram_link' => 'nullable|string',
            'linkedin_link' => 'nullable|string',
            'youtube_link' => 'nullable|string',
            'bussiness_address' => 'nullable|string',
            'monday_opening_hour' => 'nullable|string',
            'tuesday_opening_hour' => 'nullable|string',
            'wednesday_opening_hour' => 'nullable|string',
            'thursday_opening_hour' => 'nullable|string',
            'friday_opening_hour' => 'nullable|string',
            'saturday_opening_hour' => 'nullable|string',
            'sunday_opening_hour' => 'nullable|string',
            'type' =>'nullable|string',
        ]);
        $params = $request->except('_token');

        $business = $this->BusinessLeadRepository->updateLeadBusiness($params);

        if (!$business) {
            return $this->responseRedirectBack('Error occurred while updating business lead.', 'error', true, true);
        }
        return $this->responseRedirectBack('Business Lead updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $business = $this->BusinessLeadRepository->deleteLeadBusiness($id);

        if (!$business) {
            return $this->responseRedirectBack('Error occurred while deleting business lead.', 'error', true, true);
        }
        return $this->responseRedirect('admin.bussinesslead.index', 'Business Lead deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $business = $this->BusinessLeadRepository->updateBusinessLeadStatus($params);

        if ($business) {
            return response()->json(array('message'=>'Business Lead status successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $businesses = $this->BusinessLeadRepository->detailsBusinessLead($id);
        $business = $businesses[0];

        $this->setPageTitle('Business Lead', 'Business Lead Details : '.$business->bussiness_name);
        return view('admin.bussinesslead.details', compact('business'));
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

                    // Insert into database
                    foreach ($importData_arr as $importData) {
                        // $storeData = 0;
                        // if(isset($importData[5]) == "Carry In") $storeData = 1;

                        $insertData = array(
                            "bussiness_name" => isset($importData[0]) ? $importData[0] : null,
                            "category" => isset($importData[1]) ? $importData[1] : null,
                            "service_description" => isset($importData[2]) ? $importData[2] : null,
                            "description" => isset($importData[3]) ? $importData[3] : null,
                            "email" => isset($importData[4]) ? $importData[4] : null,
                            "mobile_no" => isset($importData[5]) ? $importData[5] : null,
                            "alt_mobile_no" => isset($importData[6]) ? $importData[6] : null,


                            "facebook_link" => isset($importData[12]) ? $importData[12] : null,

                            "twitter_link" => isset($importData[13]) ? $importData[13] : null,
                            "instagram_link" => isset($importData[14]) ? $importData[14] : null,
                            "youtube_link" => isset($importData[15]) ? $importData[15] : null,
                            "bussiness_address" => isset($importData[16]) ? $importData[16] : null,
                            "monday_opening_hour" => isset($importData[17]) ? $importData[17] : null,
                            "tuesday_opening_hour" => isset($importData[18]) ? $importData[18] : null,
                            "wednesday_opening_hour" => isset($importData[19]) ? $importData[19] : null,
                            "thursday_opening_hour" => isset($importData[20]) ? $importData[20] : null,
                            "friday_opening_hour" => isset($importData[21]) ? $importData[21] : null,

                            "saturday_opening_hour" => isset($importData[22]) ? $importData[22] : null,
                            "sunday_opening_hour" => isset($importData[23]) ? $importData[23] : null,
                            "type" => isset($importData[24]) ? $importData[24] : null,

                            "status" => isset($importData[27]) ? $importData[27] : null,
                        );
                        // echo '<pre>';print_r($insertData);exit();
                        BusinessLeads::insertData($insertData);
                    }
                    Session::flash('message', 'Import Successful.');
                } else {
                    Session::flash('message', 'File too large. File must be less than 50MB.');
                }
            } else {
                Session::flash('message', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
            }
        } else {
            Session::flash('message', 'No file found.');
        }
        return redirect()->route('admin.bussinesslead.index');
    }

    // public function export()
    // {
    //     return Excel::download(new DirectoryExport, 'directory.xlsx');
    // }
    
    
    
     /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function council(Request $request)
    {
        
        if (!empty($request->term)) {
             $businesses = $this->BusinessLeadRepository->getSearchBussinesscouncil($request->term);

         } else {
            $businesses =  BusinessSignupPage::paginate(25);
         }
        $this->setPageTitle('Council', 'List of all Council');
        return view('admin.bussinesslead.council', compact('businesses'));
    }
}
