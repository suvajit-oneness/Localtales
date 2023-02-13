<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Suburb;
use App\Models\User;
use App\Contracts\CollectionContract;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;
use App\Models\CollectionDirectory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CollectionExport;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLogCsv;
use Illuminate\Support\Facades\Session as FacadesSession;
class CollectionController extends BaseController
{
    protected $DirectoryRepository;

    /**
     * CollectionController constructor.
     * @param CollectionRepository $CollectionRepository
     */

    public function __construct(CollectionContract $CollectionRepository)
    {
        $this->CollectionRepository = $CollectionRepository;
    }

    /**
     * List all the states
     */
    public function index(Request $request)
    {

        if (!empty($request->term)) {
            // dd($request->term);
            $col = $this->CollectionRepository->getSearchCollection($request->term);

            //dd($col);
        } else {
            $col =  Collection::where('status', 1)->paginate(20);
        }
        $this->setPageTitle('Collection', 'List of all collection');
        return view('admin.collection.index', compact('col'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Collection', 'Create Collection');
        $suburb = $this->CollectionRepository->getAllSuburb();
        return view('admin.collection.create', compact('suburb'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // $request->validate([
        //     'title'      =>   'required|string|min:1',
        //     'meta_key'      =>  'required|string|min:1',
        //     'bottom_content'      =>  'required|string|min:1',
        //     'description'      =>  'required|string|min:1',
        //     'pin_code'      =>  'required|integer|min:1',
        //     'address'      =>  'required|string|min:1',
        //     'suburb'      =>  'required|string|min:1',
        //     'meta_title'      =>  'required|string|min:1',
        //     'meta_key'      =>  'required|string|min:1',
        //     'meta_description'      =>  'required|string|min:1',
        //     'image' => 'required|mimes:jpg,jpeg,png|max:10000000',
        // ]);

        $slug = Str::slug($request->title, '-');
        $slugExistCount = Collection::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

        // send slug
        request()->merge(['slug' => $slug]);
        $params = $request->except('_token');

        // dd($params);
        $collection = $this->CollectionRepository->createCollection($params);

        if (!$collection) {
            return $this->responseRedirectBack('Error occurred while creating collection.', 'error', true, true);
        }
        return $this->responseRedirect('admin.collection.index', 'collection has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetcollection = $this->CollectionRepository->findCollectionById($id);
        $suburb = $this->CollectionRepository->getAllSuburb();
        //dd($suburb);
        $this->setPageTitle('collection', 'Edit collection : ' . $targetcollection->title);
        return view('admin.collection.edit', compact('targetcollection', 'suburb'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        // $this->validate($request, [
        //     'title'      =>  'required|max:191',
        //     'short_description'      =>  'required|max:191',
        //     'bottom_content'      =>  'required|max:191',
        //     'description'      =>  'required|max:191',
        //     'pin_code'      =>  'required|max:191',
        //     'suburb_id'      =>  'required|max:191',
        //     'meta_title'      =>  'required|max:191',
        //     'meta_key'      =>  'required|max:191',
        //     'meta_description'      =>  'required|max:191',
        //     'image' => 'required|mimes:jpg,jpeg,png|max:10000000',
        // ]);
        $slug = Str::slug($request->name, '-');
        $slugExistCount = Collection::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

        // send slug
        request()->merge(['slug' => $slug]);
        $params = $request->except('_token');

        $targetcollection = $this->CollectionRepository->updateCollection($params);

        if (!$targetcollection) {
            return $this->responseRedirectBack('Error occurred while updating collection.', 'error', true, true);
        }
        return $this->responseRedirectBack('collection has been updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $targetcollection = $this->CollectionRepository->deleteCollection($id);

        if (!$targetcollection) {
            return $this->responseRedirectBack('Error occurred while deleting collection.', 'error', true, true);
        }
        return $this->responseRedirect('admin.collection.index', 'collection has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $targetdirectory = $this->CollectionRepository->updateCollectionStatus($params);

        if ($targetdirectory) {
            return response()->json(array('message' => 'Collection status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetcollection = $this->CollectionRepository->detailsCollection($id);
        $collection = $targetcollection[0];

        $this->setPageTitle('Collection', 'collection Details : ' . $collection->name);
        return view('admin.collection.details', compact('collection'));
    }

     public function directory($id)
    {
        $targetcollection = $this->CollectionRepository->detailsCollection($id);
        $collection = $targetcollection[0];
        $directory = DB::select("SELECT * from directories where address like '%$collection->suburb%' and category_tree like '%$collection->category%'");
       // dd($directory);
        $this->setPageTitle('Collection', 'collection Details : ' . $collection->name);
        return view('admin.collection.directory', compact('collection','directory'));
    }


    public function directorystore(Request $request)
    {
         //dd($request->all());
        $this->validate($request, [
            'collection_id'      =>  'required|max:191',
            'directory_id'      =>  'required',
        ]);
        foreach ($request->directory_id as $value) {
                $dir = new CollectionDirectory;
                $dir->collection_id = $request->collection_id;
                $dir->directory_id = $value;
                $dir->save();
                }

        if (!$dir) {
            return $this->responseRedirectBack('Error occurred while creating CollectionDirectory.', 'error', true, true);
        }
        return $this->responseRedirect('admin.collection.index', 'CollectionDirectory has been created successfully', 'success', false, false);
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
                    $count = 0;
                     $fail = 0;
                      $count = $total = 0;
                      $item='';
                        $successArr = $failureArr = [];
                    // Insert into database
                    foreach ($importData_arr as $importData) {

                        $commaSeperatedCats = '';

                        $storeData = 0;
                        if (isset($importData[14]) == "Carry In") $storeData = 1;
                        $titleArr = explode(',', $importData[1]);
                        foreach ($titleArr as $titleKey => $titleValue) {
                            // slug generate
                            $slug = Str::slug($titleValue, '-');
                            $slugExistCount = DB::table('collections')->where('title', $titleValue)->count();
                            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
                            if (!empty($importData[2])) {
                                    $code= Suburb::where('name',$importData[2])->get();
                                    //dd($code[0]);
                                    $state = $code[0]->state ?? '';
                                    $pin = $code[0]->pin_code ?? '';
                                    $state_code = $code[0]->short_state ?? '';
                            $insertData = array(
                                "meta_key" => isset($importData[0]) ? $importData[0] : null,
                                "title" => $titleValue,
                                "slug" => $slug,
                                "state" => $state,
                                "pin_code" => $pin,
                                "state_code" => $state_code,
                                "suburb" => isset($importData[2]) ? $importData[2] : null,
                                "category" => isset($importData[3]) ? $importData[3] : null,
                                "short_description" => isset($importData[4]) ? $importData[4] : null,
                                "paragraph1_heading" => isset($importData[5]) ? $importData[5] : null,
                                "paragraph1" => isset($importData[6]) ? $importData[6] : null,
                                "paragraph2_heading" => isset($importData[7]) ? $importData[7] : null,
                                "paragraph2" => isset($importData[8]) ? $importData[8] : null,
                                "paragraph3_heading" => isset($importData[9]) ? $importData[9] : null,
                                "paragraph3" => isset($importData[10]) ? $importData[10] : null,
                                "google_doc" => isset($importData[11]) ? $importData[11] : null,
                                "completion" => isset($importData[12]) ? $importData[12] : null,
                                "who" => isset($importData[13]) ? $importData[13] : null,
                                "quality_check" => isset($importData[14]) ? $importData[14] : null,
                            );

                            $resp = Collection::insertData($insertData, $count, $successArr, $failureArr);
                            $count = $resp['count'];
                            $insertId = $resp['id'];
                            $successArr = $resp['successArr'];
                            $failureArr = $resp['failureArr'];
                            $total++;
                            $catExistCheck = DB::select("SELECT * from directories where address like '%$importData[2]%' and category_tree like '%$importData[3]%'");

                            if($insertId != null) {
                                foreach ($catExistCheck as $cat) {
                                    $insertDirCatId = $cat->id;

                                    $dirCat = new CollectionDirectory();
                                    $dirCat->collection_id = $resp['id'];
                                    $dirCat->directory_id = $insertDirCatId;
                                    $dirCat->save();
                                }
                            }
                        }
                    }
                   }
                    $store = new ActivityLogCsv;
                    $store->user_id =  Auth::guard('admin')->user()->id;
                    $store->csv_file_location = $location . "/" . $filename;
                    $store->total_rows = $total;
                    $store->success_count = $count;
                    $store->success_array = (count($resp['successArr']) > 0) ? json_encode($resp['successArr']) : '';
                    $store->failure_count = $total - $count;
                    $store->failure_array = (count($resp['failureArr']) > 0) ? json_encode($resp['failureArr']) : '';
                    $store->csv_type = 'collection';
                    $store->save();

                    if($count == 0) {
                        FacadesSession::flash('csv', 'Already Uploaded. ');
                    } else {
                        FacadesSession::flash('csv', 'Import Successful. '.$count.' Data Uploaded ' );
                    }
                } else {
                    FacadesSession::flash('message', 'File too large. File must be less than 50MB.');
                }
            } else {
                FacadesSession::flash('message', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
            }
        } else {
            FacadesSession::flash('message', 'No file found.');
        }

        return redirect()->route('admin.collection.index');
    }
    // csv upload


    public function export()
    {
        return Excel::download(new CollectionExport, 'collection.xlsx');
    }

     public function upload_bulk_images(Request $request)
    {
        foreach ($request->image as $image) {
            $name = $image->getClientOriginalName();
            $image->move(public_path() . '/admin/uploads/collection/images/', $name);
        }
        FacadesSession::flash('image_uploaded', 'All images imported Successfully.');
        return redirect()->back();
    }
}
