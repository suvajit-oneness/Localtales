<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\DirectorySubCategoryContract;
use Illuminate\Http\Request;
use App\Models\DirectoryCategory;
use App\Models\ActivityLogCsv;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Session;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DirectoryCategoryExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session as FacadesSession;

class DirectorySubCategoryController extends BaseController
{
    /**
     * @var DirectoryCategoryContract
     */
    protected $DirectoryCategoryRepository;


    /**
     * PageController constructor.
     * @param DirectorySubCategoryContract $DirectorySubCategoryRepository
     */
    public function __construct(DirectorySubCategoryContract $DirectorySubCategoryRepository)
    {
        $this->DirectorySubCategoryRepository = $DirectorySubCategoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {

        if (!empty($request->term)) {

            $categories = $this->DirectorySubCategoryRepository->getSearchSubcategory($request->term);
        } else {
            $categories = DirectoryCategory::where('child_category','!=','NULL')->orderby('child_category')->latest('id')->groupby('child_category')->paginate(25);
        }

        $this->setPageTitle('Sub Category', 'List of all Subcategories');
        return view('admin.dirsubcategory.index', compact('categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('SubCategory', 'Create SubCategory');
        $categories=DirectoryCategory::where('type',1)->orderby('parent_category')->get();
        return view('admin.dirsubcategory.create',compact('categories'));
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
            'child_category' => 'required|string|min:1',

        ]);
        $params = $request->except('_token');
        $category = $this->DirectorySubCategoryRepository->createSubCategory($params);
        if (!$category) {
            return $this->responseRedirectBack('Error occurred while creating SubCategory.', 'error', true, true);
        }
        return $this->responseRedirect('admin.dirsubcategory.index', 'Category has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetCategory = $this->DirectorySubCategoryRepository->findSubCategoryById($id);
        $categories=DirectoryCategory::where('type',1)->orderby('parent_category')->get();
        $this->setPageTitle('SubCategory', 'Edit SubCategory : ' . $targetCategory->title);
        return view('admin.dirsubcategory.edit', compact('targetCategory','categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'child_category' => 'required|string|min:1|max:255',
            'child_category_image' => 'nullable|mimes:jpg,jpeg,png,bmp,svg,gif',
            'child_description' => 'required|string|min:1',
            'child_short_content' => 'nullable|string|min:1',
            'child_medium_content' => 'nullable|string|min:1',
            'child_long_content' => 'nullable|string|min:1',
        ]);

        $category = DirectoryCategory::findOrFail($request->id);
        $category->type = 0;
        $category->child_category = !empty($request->child_category) ? $request->child_category : '';
        $category->parent_category = !empty($request->parent_category) ? $request->parent_category : '';
        // image
        if (!empty($request->child_category_image)) {
            $image = $request->child_category_image;
            $ext = $image->getClientOriginalExtension();
            $imageName = mt_rand().'_'.time().".".$ext;
            $image->move("admin/uploads/directorysubcategory/images/",$imageName);
            $category->child_category_image = $imageName;
        }

        $category->child_description = !empty($request->child_description) ? $request->child_description : '';
        $category->child_short_content = !empty($request->child_short_content) ? $request->child_short_content : '';
        $category->child_medium_content = !empty($request->child_medium_content) ? $request->child_medium_content : '';
        $category->child_long_content = !empty($request->child_long_content) ? $request->child_long_content : '';
        $category->save();
        return $this->responseRedirectBack('SubCategory has been updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $category = $this->DirectorySubCategoryRepository->deleteSubCategory($id);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while deleting SubCategory.', 'error', true, true);
        }
        return $this->responseRedirect('admin.dirsubcategory.index', 'SubCategory has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $category = $this->DirectorySubCategoryRepository->updatesubCategoryStatus($params);

        if ($category) {
            return response()->json(array('message' => 'SubCategory status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $categories = $this->DirectorySubCategoryRepository->detailsSubCategory($id);
        $category = $categories[0];

        $this->setPageTitle('SubCategory', 'SubCategory Details : ' . $category->title);
        return view('admin.dirsubcategory.details', compact('category'));
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
                        $count = $total= 0;
                        $successArr = $failureArr =[];
                    // Insert into database
                    foreach ($importData_arr as $importData) {
                        if (!empty($importData[0])) {
                            // dd($importData[0]);
                            $titleArr = explode(',', $importData[0]);

                            // echo '<pre>';print_r($titleArr);exit();

                            foreach ($titleArr as $titleKey => $titleValue) {
                                // slug generate
                                $slug = Str::slug($titleValue, '-');
                                $slugExistCount = DB::table('directory_categories')->where('child_category', $titleValue)->count();
                                if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

                                $insertData = array(
                                    "child_category" => $titleValue,
                                    "child_category_slug" => $slug,
                                    "child_category_image" => isset($importData[1]) ? $importData[1] : null,
                                );

                                $resp =DirectoryCategory::insertData($insertData,$count,$successArr,$failureArr);
                                $count = $resp['count'];
                                $successArr = $resp['successArr'];
                                $failureArr = $resp['failureArr'];
                                $total++;
                            }
                        }


                    }
                   // Session::flash('message', 'Import Successful.');
                       $store = new ActivityLogCsv;
                        $store->user_id =  Auth::guard('admin')->user()->id;
                        $store->csv_file_location = $location . "/" . $filename;
                        $store->total_rows = $total;
                        $store->success_count = $count;
                        $store->success_array = (count($resp['successArr']) > 0) ? json_encode($resp['successArr']) : '';
                        $store->failure_count = $total - $count;
                        $store->failure_array = (count($resp['failureArr']) > 0) ? json_encode($resp['failureArr']) : '';
                        $store->csv_type = 'directory category';
                        $store->save();
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
        return redirect()->route('admin.dirsubcategory.index');
    }
    // csv upload
    public function export()
    {
        return Excel::download(new DirectorySubCategoryExport, 'directorysubcat.xlsx');
    }

    public function upload_bulk_images(Request $request)
    {
        foreach ($request->image as $image) {
            $name = $image->getClientOriginalName();
            $image->move(public_path() . '/admin/uploads/directorycategory/images/', $name);
        }
        File::flash('image_uploaded', 'All images imported Successfully.');
        return redirect()->back();
    }
}
