<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\HelpSubCategoryContract;
use Illuminate\Http\Request;
use App\Models\HelpSubCategory;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubcategoryExport;
use Illuminate\Support\Facades\DB;

class HelpSubCategoryController extends BaseController
{
    /**
     * @var SubCategoryContract
     */
    protected $HelpSubCategoryRepository;


    /**
     * PageController constructor.
     * @param SubCategoryContract $HelpSubCategoryRepository
     */
    public function __construct(HelpSubCategoryContract $HelpSubCategoryRepository)
    {
        $this->HelpSubCategoryRepository = $HelpSubCategoryRepository;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        $data =  HelpSubCategory::paginate(5);
        if (!empty($request->term)) {
            // dd($request->term);
             $subcategories = $this->HelpSubCategoryRepository->getSearchSubcategory($request->term);

            // dd($categories);
         } else {
        $subcategories = HelpSubCategory::latest('id')->paginate(25);
         }
        $categories = $this->HelpSubCategoryRepository->listCategory();
        $this->setPageTitle('Sub Category', 'List of all sub categories');
        return view('admin.help.subcategory.index', compact('subcategories','categories','data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Sub Category', 'Create Subcategory');
        $categories = $this->HelpSubCategoryRepository->listCategory();

        return view('admin.help.subcategory.create',compact('categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required|max:191',
            'category_id'      =>  'required|max:191',
        ]);
        $slug = Str::slug($request->name, '-');
        $slugExistCount = HelpSubCategory::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);

        // send slug
        request()->merge(['slug' => $slug]);
        $params = $request->except('_token');

        $targetsubCategory = $this->HelpSubCategoryRepository->createSubCategory($params);

        if (!$targetsubCategory) {
            return $this->responseRedirectBack('Error occurred while creating sub category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.helpsubcategory.index', 'Category has been created successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetsubCategory = $this->HelpSubCategoryRepository->findSubCategoryById($id);
        $categories = $this->HelpSubCategoryRepository->listCategory();
        $this->setPageTitle('Sub Category', 'Edit Sub Category : '.$targetsubCategory->title);
        return view('admin.help.subcategory.edit', compact('targetsubCategory','categories'));
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
            'category_id'      =>  'required|max:191',
        ]);
        $slug = Str::slug($request->name, '-');
        $slugExistCount = HelpSubCategory::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
        $params = $request->except('_token');

        $subcategory = $this->HelpSubCategoryRepository->updateSubCategory($params);

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
        $subcategory = $this->HelpSubCategoryRepository->deleteSubCategory($id);

        if (!$subcategory) {
            return $this->responseRedirectBack('Error occurred while deleting sub category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.helpsubcategory.index', 'sub Category has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $subcategory = $this->HelpSubCategoryRepository->updatesubCategoryStatus($params);

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
        $categories = $this->HelpSubCategoryRepository->detailsSubCategory($id);
        $subcategory = $categories[0];

        $this->setPageTitle('SubCategory', 'Sub Category Details : '.$subcategory->title);
        return view('admin.help.subcategory.details', compact('subcategory'));
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
                        HelpSubCategory::insertData($insertData);
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
        return redirect()->route('admin.helpsubcategory.index');
    }
    public function export()
    {
        return Excel::download(new SubcategoryExport, 'subcategory.xlsx');
    }
}
