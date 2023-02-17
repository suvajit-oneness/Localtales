<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\SubCategoryContract;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubcategoryExport;
use Illuminate\Support\Facades\DB;
class SubCategoryManagementController extends BaseController
{
    /**
     * @var SubCategoryContract
     */
    protected $SubCategoryRepository;


    /**
     * PageController constructor.
     * @param SubCategoryContract $SubCategoryRepository
     */
    public function __construct(SubCategoryContract $SubCategoryRepository)
    {
        $this->SubCategoryRepository = $SubCategoryRepository;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
       
        if (!empty($request->term)) {
            // dd($request->term);
             $subcategories = $this->SubCategoryRepository->getSearchSubcategory($request->term);

            // dd($categories);
         } else {
           $subcategories = SubCategory::orderby('title')->paginate(35);
         }
        $categories = $this->SubCategoryRepository->listCategory();
        $this->setPageTitle('Sub Category', 'List of all sub categories');
        return view('admin.subcategory.index', compact('subcategories','categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Sub Category', 'Create Subcategory');
        $categories = $this->SubCategoryRepository->listCategory();

        return view('admin.subcategory.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:191',
            'category_id' => 'required|integer|min:1',
            "description" => "nullable|string|min:1",
            "image" => "nullable|image|max:200"
        ]);

        $slug = Str::slug($request->name, '-');
        $slugExistCount = SubCategory::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);

        // send slug
        request()->merge(['slug' => $slug]);
        $params = $request->except('_token');

        $targetsubCategory = $this->SubCategoryRepository->createSubCategory($params);

        if (!$targetsubCategory) {
            return $this->responseRedirectBack('Error occurred while creating sub category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.subcategory.index', 'Category has been created successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetsubCategory = $this->SubCategoryRepository->findSubCategoryById($id);
        $categories = $this->SubCategoryRepository->listCategory();
        $this->setPageTitle('Sub Category', 'Edit Sub Category : '.$targetsubCategory->title);
        return view('admin.subcategory.edit', compact('targetsubCategory','categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:191',
            'category_id' => 'required|integer|min:1',
            "description" => "nullable|string|min:1",
            "image" => "nullable|image|max:200"
        ]);

        $slug = Str::slug($request->name, '-');
        $slugExistCount = SubCategory::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
        $params = $request->except('_token');

        $subcategory = $this->SubCategoryRepository->updateSubCategory($params);

        if (!$subcategory) {
            return $this->responseRedirectBack('Error occurred while updating sub category.', 'error', true, true);
        }
        return $this->responseRedirectBack('SubCategory has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $subcategory = $this->SubCategoryRepository->deleteSubCategory($id);

        if (!$subcategory) {
            return $this->responseRedirectBack('Error occurred while deleting sub category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.subcategory.index', 'sub Category has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $subcategory = $this->SubCategoryRepository->updatesubCategoryStatus($params);

        if ($subcategory) {
            return response()->json(array('message'=>'SubCategory status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $categories = $this->SubCategoryRepository->detailsSubCategory($id);
        $subcategory = $categories[0];

        $this->setPageTitle('SubCategory', 'Sub Category Details : '.$subcategory->title);
        return view('admin.subcategory.details', compact('subcategory'));
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
                            "slug" => isset($importData[1]) ? $importData[1] : null,
                            "category_id" => isset($importData[2]) ? $importData[2] : null,

                        );
                        // echo '<pre>';print_r($insertData);exit();
                        SubCategory::insertData($insertData);
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
        return redirect()->route('admin.subcategory.index');
    }
    public function export()
    {
        return Excel::download(new SubcategoryExport, 'subcategory.xlsx');
    }
}


