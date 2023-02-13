<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use App\Contracts\FaqContract;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;

class FaqManagementController extends BaseController
{
    protected $FaqRepository;

    /**
     * IndexManagementController constructor.
     * @param FaqRepository $FaqRepository
     */

    public function __construct(FaqContract $FaqRepository)
    {
        $this->FaqRepository = $FaqRepository;
    }

    /**
     * List all the states
     */
    public function index()
    {
        $faq = $this->FaqRepository->listfaq();

        $this->setPageTitle('Faq Screen', 'Faq');
        return view('admin.faq.index', compact('faq'));
    }

 /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Faq', 'Create Faq');
        // $blogcat = $this->BlogRepository->getBlogcategories();
        // $blogsubcat = $this->BlogRepository->getBlogsubcategories();
        return view('admin.faq.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|min:1',
            'subcategory' => 'required|string|min:1',

            'question' => 'required|string|min:1',
            'answer' => 'required|string',

        ]);

        $faq = $this->FaqRepository->createfaq($request->except('_token'));

        if (!$faq) {
            return $this->responseRedirectBack('Error occurred while creating Faq.', 'error', true, true);
        }
        return $this->responseRedirect('admin.faq.index', 'Faq has been created successfully' ,'success',false, false);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $faq = $this->FaqRepository->findfaqById($id);

        $this->setPageTitle('Faq', 'Edit Faq : '.$faq->category);
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'category' => 'required|string|min:1',
            'subcategory' => 'required|string|min:1',

            'question' => 'required|string|min:1',
            'answer' => 'required|string',

        ]);

        $params = $request->except('_token');

        $faq = $this->FaqRepository->updatefaq($params);

        if (!$faq) {
            return $this->responseRedirectBack('Error occurred while updating Faq.', 'error', true, true);
        }
        return $this->responseRedirectBack('Faq has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $Faq = $this->FaqRepository->deletefaq($id);

        if (!$Faq) {
            return $this->responseRedirectBack('Error occurred while deleting Faq .', 'error', true, true);
        }
        return $this->responseRedirect('admin.faq.index', 'Faq has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $faq = $this->FaqRepository->updatefaqStatus($params);

        if ($faq) {
            return response()->json(array('message'=>'Faq status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $target = $this->FaqRepository->detailsfaq($id);
        $faq = $target[0];

        $this->setPageTitle('Faq ', 'Faq  Details : '.$faq->category);
        return view('admin.faq.details', compact('faq'));
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
