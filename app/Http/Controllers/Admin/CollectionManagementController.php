<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use App\Contracts\FrontCollectionContract;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;

class CollectionManagementController extends BaseController
{
    protected $FrontCollectionRepository;

    /**
     * IndexManagementController constructor.
     * @param FrontCollectionRepository $FrontCollectionRepository
     */

    public function __construct(FrontCollectionContract $FrontCollectionRepository)
    {
        $this->FrontCollectionRepository = $FrontCollectionRepository;
    }

    /**
     * List all the states
     */
    public function index()
    {
        $collection = $this->FrontCollectionRepository->listsfrontcollection();

        $this->setPageTitle('Collection Screen', 'Collection');
        return view('admin.frontcollection.index', compact('collection'));
    }




    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $collection = $this->FrontCollectionRepository->findfrontcollectionById($id);

        $this->setPageTitle('Collection', 'Edit Home Page : '.$collection->pretty_name);
        return view('admin.frontcollection.edit', compact('collection'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'pretty_name'      =>  'required|string|min:1',
            'content'      =>  'required|string|min:1',
            'content1'      =>  'required|string|min:1',
           // 'content2'      =>  'required|string|min:1',
            //'image'      =>  'required|mimes:jpg,jpeg,png|max:1000',
            'banner_image'      => 'required|mimes:jpg,jpeg,png|min:1000',
            //'image2'      => 'required|mimes:jpg,jpeg,png|min:1000',
            //'logo'      =>  'required|mimes:jpg,jpeg,png|min:1000',

        ]);

        $params = $request->except('_token');

        $splash = $this->FrontCollectionRepository->updatefrontcollection($params);

        if (!$splash) {
            return $this->responseRedirectBack('Error occurred while updating Collection.', 'error', true, true);
        }
        return $this->responseRedirectBack('Collection has been updated successfully' ,'success',false, false);
    }





    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $target = $this->FrontCollectionRepository->detailsfrontcollection($id);
        $splash = $target[0];

        $this->setPageTitle('Home ', 'Collection  Details : '.$splash->key);
        return view('admin.frontcollection.details', compact('splash'));
    }


    // public function csvStore(Request $request)
    // {
    //     if (!empty($request->file)) {
    //         // if ($request->input('submit') != null ) {
    //         $file = $request->file('file');
    //         // File Details
    //         $filename = $file->getClientOriginalName();
    //         $extension = $file->getClientOriginalExtension();
    //         $tempPath = $file->getRealPath();
    //         $fileSize = $file->getSize();
    //         $mimeType = $file->getMimeType();

    //         // Valid File Extensions
    //         $valid_extension = array("csv");
    //         // 50MB in Bytes
    //         $maxFileSize = 50097152;
    //         // Check file extension
    //         if (in_array(strtolower($extension), $valid_extension)) {
    //             // Check file size
    //             if ($fileSize <= $maxFileSize) {
    //                 // File upload location
    //                 $location = 'admin/uploads/csv';
    //                 // Upload file
    //                 $file->move($location, $filename);
    //                 // Import CSV to Database
    //                 $filepath = public_path($location . "/" . $filename);
    //                 // Reading file
    //                 $file = fopen($filepath, "r");
    //                 $importData_arr = array();
    //                 $i = 0;
    //                 while (($filedata = fgetcsv($file, 10000, ",")) !== FALSE) {
    //                     $num = count($filedata);
    //                     // Skip first row
    //                     if ($i == 0) {
    //                         $i++;
    //                         continue;
    //                     }
    //                     for ($c = 0; $c < $num; $c++) {
    //                         $importData_arr[$i][] = $filedata[$c];
    //                     }
    //                     $i++;
    //                 }
    //                 fclose($file);

    //                 // echo '<pre>';print_r($importData_arr);exit();

    //                 // Insert into database
    //                 foreach ($importData_arr as $importData) {
    //                     $storeData = 0;
    //                     if(isset($importData[5]) == "Carry In") $storeData = 1;

    //                     $insertData = array(
    //                         "name" => isset($importData[0]) ? $importData[0] : null,
    //                         "slug" => isset($importData[0]) ? $importData[0] : null,

    //                     );
    //                     // echo '<pre>';print_r($insertData);exit();
    //                     State::insertData($insertData);
    //                 }
    //                 Session::flash('message', 'Import Successful.');
    //             } else {
    //                 Session::flash('message', 'File too large. File must be less than 50MB.');
    //             }
    //         } else {
    //             Session::flash('message', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
    //         }
    //     } else {
    //         Session::flash('message', 'No file found.');
    //     }
    //     return redirect()->route('admin.state.index');
    // }
    // csv upload
}
