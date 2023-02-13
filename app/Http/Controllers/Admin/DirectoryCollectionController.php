<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CollectionDirectory;
use App\Models\Directory;
use App\Models\Collection;
use App\Models\User;
use App\Contracts\CollectionDirectoryContract;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DirectoryExport;
use Illuminate\Support\Facades\DB;

class DirectoryCollectionController extends BaseController
{
    protected $DirectoryRepository;

    /**
     * DirectoryCollectionController constructor.
     * @param CollectionDirectoryRepository $CollectionDirectoryRepository
     */

    public function __construct(CollectionDirectoryContract $CollectionDirectoryRepository)
    {
        $this->CollectionDirectoryRepository = $CollectionDirectoryRepository;
    }

    /**
     * List all the states
     */
    public function index()
    {
        $directory = $this->CollectionDirectoryRepository->listCollectionDirectory();

        $this->setPageTitle('CollectionDirectory', 'List of all CollectionDirectory');
        return view('admin.collectiondirectory.index', compact('directory'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $cid = request()->input('collection');
        $this->setPageTitle('CollectionDirectory', 'Create CollectionDirectory');
        $col = $this->CollectionDirectoryRepository->getAllCollection();
        $collection=Collection::where('id',$cid)->get();
        // $directory = $this->CollectionDirectoryRepository->getAllDirectory();
        if (isset($request->keyword)) {

            $keyword = (isset($request->keyword) && $request->keyword != '') ? $request->keyword : '';
            $directory = $this->CollectionDirectoryRepository->getSearchDirectory($keyword);
        } else {
            $directory = Directory::paginate(8);
        }
        if(isset($request->code) || isset($request->keyword) ||isset($request->name)||isset($request->rating)) {
            $category = $request->directory_category;
            $code = $request->code;
            $keyword = $request->keyword;
            $type = $request->type;
            $name = $request->name;
            $rating = $request->rating;

            if (!empty($keyword)) {
                //$keywordQuery = "AND address like '%$keyword' ";
                $directoryList = DB::table('directories')->whereRaw("address like '%$keyword'")->paginate(18)->appends(request()->query());
            }
            if (!empty($rating)) {
                //$keywordQuery = "AND address like '%$keyword' ";
                $directoryList = DB::table('directories')->whereRaw("rating like '%$rating'")->paginate(18)->appends(request()->query());
            }
            if (!empty($name)) {

                $directoryList = DB::table('directories')->whereRaw("name like '%$name%'")->paginate(18)->appends(request()->query());
            }
            if (!empty($code)) {
            // if primary category
            if ($type == "primary") {
                $keywordQuery = "AND name like '%$name%' ";
                $directoryList = DB::table('directories')->whereRaw("address like '%$keyword' $keywordQuery and
                ( category_id like '$request->code,%' or category_id like '%,$request->code,%')")->paginate(18)->appends(request()->query());

            } elseif ($type == "secondary") {
                $keywordQuery = "AND name like '%$name%' ";
                $directoryList = DB::table('directories')->whereRaw("address like '%$keyword' $keywordQuery and
                ( category_id like '$request->code,%' or category_id like '%,$request->code,%')")->paginate(18)->appends(request()->query());
            }
        }
       }
        else{
            $directoryList = CollectionDirectory::where('collection_id', $cid)
            ->with('directory')->paginate(18)->appends(request()->query());
           }

        return view('admin.collectiondirectory.create', compact('col', 'directory','directoryList','collection'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'collection_id'      =>  'required|max:191',
            'directory_id'      =>  'required',
        ]);


        $params = $request->except('_token');

        $state = $this->CollectionDirectoryRepository->createCollectionDirectory($params);

        if (!$state) {
            return $this->responseRedirectBack('Error occurred while creating CollectionDirectory.', 'error', true, true);
        }
        return $this->responseRedirect('admin.collection.index', 'State has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        //$targetdirectory = $this->CollectionDirectoryRepository->findCollectionDirectoryById($id);

        $col = Collection::findOrfail($id);
        //dd($col->title);
        // $directory = $this->CollectionDirectoryRepository->getAllDirectory();

        // $directory = $this->CollectionDirectoryRepository->getAllDirectory();
        if(isset($request->code) || isset($request->keyword) ||isset($request->name)||isset($request->rating)) {
            $category = $request->directory_category;
            $code = $request->code;
            $keyword = $request->keyword;
            $type = $request->type;
            $name = $request->name;
            $rating = $request->rating;

            if (!empty($keyword)) {
                //$keywordQuery = "AND address like '%$keyword' ";
                $directoryList = DB::table('directories')->whereRaw("address like '%$keyword'")->paginate(10)->appends(request()->query());
            }
            if (!empty($rating)) {
                //$keywordQuery = "AND address like '%$keyword' ";
                $directoryList = DB::table('directories')->whereRaw("rating like '$rating%'")->paginate(10)->appends(request()->query());
            }
            if (!empty($name)) {

                $directoryList = DB::table('directories')->whereRaw("name like '%$name%'")->paginate(10)->appends(request()->query());
            }
            if (!empty($code)) {
            // if primary category
            if ($type == "primary") {
                $keywordQuery = "AND name like '%$name%' ";
                $directoryList = DB::table('directories')->whereRaw("address like '%$keyword' $keywordQuery and
                ( category_id like '$request->code,%' or category_id like '%,$request->code,%')")->paginate(10)->appends(request()->query());

            } elseif ($type == "secondary") {
                $keywordQuery = "AND name like '%$name%' ";
                $directoryList = DB::table('directories')->whereRaw("address like '%$keyword' $keywordQuery and
                ( category_id like '$request->code,%' or category_id like '%,$request->code,%')")->paginate(10)->appends(request()->query());
            }
        }
       }
        else{
           // $directoryList = CollectionDirectory::where('collection_id', $id)
            //->with('directory')->paginate(18)->appends(request()->query());
            $directoryList= Directory::paginate(10)->appends(request()->query());
           }
          // dd( $directoryList);
        $this->setPageTitle('Directory', 'Edit Directory');
        return view('admin.collectiondirectory.edit', compact('col','directoryList'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'collection_id'      =>  'required|max:191',
            'directory_id'      =>  'required|max:191',
        ]);

        $params = $request->except('_token');

        $targetstate = $this->CollectionDirectoryRepository->updateCollectionDirectory($params);

        if (!$targetstate) {
            return $this->responseRedirectBack('Error occurred while updating CollectionDirectory.', 'error', true, true);
        }
        return $this->responseRedirectBack('CollectionDirectory has been updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $targetdirectory = $this->CollectionDirectoryRepository->deleteCollectionDirectory($id);

        if (!$targetdirectory) {
            return $this->responseRedirectBack('Error occurred while deleting Directory.', 'error', true, true);
        }
        return $this->responseRedirect('admin.collection.index', 'Directory has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $targetdirectory = $this->CollectionDirectoryRepository->updateCollectionDirectoryStatus($params);

        if ($targetdirectory) {
            return response()->json(array('message' => 'CollectionDirectory status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetdirectory = $this->CollectionDirectoryRepository->detailsCollectionDirectory($id);
        $directory = $targetdirectory[0];

        $this->setPageTitle('Directory', 'CollectionDirectory Details : ' . $directory->name);
        return view('admin.collectiondirectory.details', compact('directory'));
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
    //                         "email" => isset($importData[1]) ? $importData[1] : null,
    //                         "password" => isset($importData[2]) ? $importData[2] : null,
    //                         "mobile" => isset($importData[3]) ? $importData[3] : null,
    //                         "address" => isset($importData[4]) ? $importData[4] : null,
    //                         "pin" => isset($importData[5]) ? $importData[5] : null,
    //                         "lat" => isset($importData[6]) ? $importData[6] : null,
    //                         "lon" => isset($importData[7]) ? $importData[7] : null,
    //                         "description" => isset($importData[8]) ? $importData[8] : null,
    //                         "service_description" => isset($importData[9]) ? $importData[9] : null,
    //                         "opening_hour" => isset($importData[10]) ? $importData[10] : null,
    //                         "website" => isset($importData[11]) ? $importData[11] : null,
    //                         "facebook_link" => isset($importData[12]) ? $importData[12] : null,

    //                         "twitter_link" => isset($importData[13]) ? $importData[13] : null,
    //                         "facebook_link" => isset($importData[14]) ? $importData[14] : null,
    //                         "image" => isset($importData[15]) ? $importData[15] : null,
    //                         "status" => isset($importData[16]) ? $importData[16] : null,
    //                     );
    //                     // echo '<pre>';print_r($insertData);exit();
    //                     Directory::insertData($insertData);
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
    //     return redirect()->route('admin.directory.index');
    // }

    // public function export()
    // {
    //     return Excel::download(new DirectoryExport, 'directory.xlsx');
    // }
    // csv upload
}
