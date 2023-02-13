<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\User;
use App\Contracts\CollectionContract;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CollectionExport;
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
        $data =  Collection::paginate(5);
        if (!empty($request->term)) {
            // dd($request->term);
             $col = $this->CollectionRepository->getSearchCollection($request->term);

             //dd($col);
         } else {
         $col = $this->CollectionRepository->listCollection();
         }
        $this->setPageTitle('Collection', 'List of all collection');
        return view('admin.collection.index', compact('col','data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Collection', 'Create Collection');
        $suburb = $this->CollectionRepository->getAllSuburb();
        return view('admin.collection.create',compact('suburb'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'title'      =>   'required|string|min:1',
            'short_description'      =>  'required|string|min:1',
            'bottom_content'      =>  'required|string|min:1',
            'description'      =>  'required|string|min:1',
            'pin_code'      =>  'required|integer|min:1',
            'address'      =>  'required|string|min:1',
            'suburb_id'      =>  'required|integer|min:1',
            'meta_title'      =>  'required|string|min:1',
            'meta_key'      =>  'required|string|min:1',
            'meta_description'      =>  'required|string|min:1',
            'rating'      =>  'required|numeric|min:1',
            'image' => 'required|mimes:jpg,jpeg,png|max:10000000',
        ]);

        $slug = Str::slug($request->title, '-');
        $slugExistCount = Collection::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);

        // send slug
        request()->merge(['slug' => $slug]);
        $params = $request->except('_token');

        $collection = $this->CollectionRepository->createCollection($params);

        if (!$collection) {
            return $this->responseRedirectBack('Error occurred while creating collection.', 'error', true, true);
        }
        return $this->responseRedirect('admin.collection.index', 'collection has been created successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetcollection = $this->CollectionRepository->findCollectionById($id);
        $suburb = $this->CollectionRepository->getAllSuburb();
        $this->setPageTitle('collection', 'Edit collection : '.$targetcollection->title);
        return view('admin.collection.edit', compact('targetcollection','suburb'));
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
            'short_description'      =>  'required|max:191',
            'bottom_content'      =>  'required|max:191',
            'description'      =>  'required|max:191',
            'pin_code'      =>  'required|max:191',
            'suburb_id'      =>  'required|max:191',
            'meta_title'      =>  'required|max:191',
            'meta_key'      =>  'required|max:191',
            'meta_description'      =>  'required|max:191',
            'image' => 'required|mimes:jpg,jpeg,png|max:10000000',
        ]);
        $slug = Str::slug($request->name, '-');
        $slugExistCount = Collection::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);

        // send slug
        request()->merge(['slug' => $slug]);
        $params = $request->except('_token');

        $targetcollection = $this->CollectionRepository->updateCollection($params);

        if (!$targetcollection) {
            return $this->responseRedirectBack('Error occurred while updating collection.', 'error', true, true);
        }
        return $this->responseRedirectBack('collection has been updated successfully' ,'success',false, false);
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
        return $this->responseRedirect('admin.collection.index', 'collection has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $targetdirectory = $this->CollectionRepository->updateCollectionStatus($params);

        if ($targetdirectory) {
            return response()->json(array('message'=>'Collection status has been successfully updated'));
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

        $this->setPageTitle('Collection', 'collection Details : '.$collection->name);
        return view('admin.collection.details', compact('collection'));
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
                        $storeData = 0;
                        if(isset($importData[5]) == "Carry In") $storeData = 1;

                        $insertData = array(
                            "title" => isset($importData[0]) ? $importData[0] : null,
                            "short_description" => isset($importData[1]) ? $importData[1] : null,
                            "bottom_content" => isset($importData[2]) ? $importData[2] : null,
                            "description" => isset($importData[3]) ? $importData[3] : null,
                            "pin_code" => isset($importData[4]) ? $importData[4] : null,
                            "suburb_id" => isset($importData[5]) ? $importData[5] : null,
                            "meta_title" => isset($importData[6]) ? $importData[6] : null,
                            "meta_key" => isset($importData[7]) ? $importData[7] : null,
                            "meta_description" => isset($importData[8]) ? $importData[8] : null,

                            "status" => isset($importData[9]) ? $importData[9] : null,
                            "created_at" => isset($importData[10]) ? $importData[10] : null,
                            "updated_at" => isset($importData[11]) ? $importData[11] : null,
                        );
                        // echo '<pre>';print_r($insertData);exit();
                        Collection::insertData($insertData);
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
        return redirect()->route('admin.collection.index');
    }
    // csv upload


    public function export()
    {
        return Excel::download(new CollectionExport, 'collection.xlsx');
    }
}
