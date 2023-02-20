<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\User;
use App\Contracts\SubCategoryLevelContract;
use App\Http\Controllers\BaseController;
use App\Models\SubCategoryLevel;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;
use Carbon\Carbon;
use App\Exports\TertiarycategoryExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session as FacadesSession;
class SubCategoryLevelController extends BaseController
{
    protected $SubCategoryLevelRepository;

    /**
     * SubCategoryLevelController constructor.
     * @param SubCategoryLevelRepository $SubCategoryLevelRepository
     */

    public function __construct(SubCategoryLevelContract $SubCategoryLevelRepository)
    {
        $this->SubCategoryLevelRepository = $SubCategoryLevelRepository;
    }

    /**
     * List all the states
     */
    public function index(Request $request)
    {
        
        if (!empty($request->term)) {
            $subcatlevel = $this->SubCategoryLevelRepository->getSearchSubcategorylevel($request->term);
        } else {
            $subcatlevel =  SubCategoryLevel::orderBy('title')->paginate(25);
        }

        $subcat = $this->SubCategoryLevelRepository->getSubCategory();
        $this->setPageTitle('Tertiary Category', 'List of all Tertiary Category');
        return view('admin.subcategorylevel.index', compact('subcatlevel','subcat','request'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Tertiary Category', 'Create Tertiary Category');
        $subcat = $this->SubCategoryLevelRepository->getSubCategory();
        return view('admin.subcategorylevel.create',compact('subcat'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:191',
            "sub_category_id" => "required|integer|min:1",
            "description" => "nullable|string|min:1",
            "image" => "nullable|image|max:200",
        ]);

        $slug = Str::slug($request->name, '-');
        $slugExistCount = State::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);

        // send slug
        request()->merge(['slug' => $slug]);

        $params = $request->except('_token');

        $state = $this->SubCategoryLevelRepository->createSubCategoryLevel($params);

        if (!$state) {
            return $this->responseRedirectBack('Error occurred while creating Tertiary Category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.sub-category-level2.index', 'Tertiary Category has been created successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetsubcat = $this->SubCategoryLevelRepository->findSubCategoryLevelById($id);
        $subcat = $this->SubCategoryLevelRepository->getSubCategory();
        $this->setPageTitle('Tertiary Category', 'Edit Tertiary Category : '.$targetsubcat->title);
        return view('admin.subcategorylevel.edit', compact('targetsubcat','subcat'));
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
            "sub_category_id" => "required|integer|min:1",
            "description" => "nullable|string|min:1",
            "image" => "nullable|image|max:200",
        ]);

        $slug = Str::slug($request->name, '-');
        $slugExistCount = State::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
        $params = $request->except('_token');

        $targetstate = $this->SubCategoryLevelRepository->updateSubCategoryLevel($params);

        if (!$targetstate) {
            return $this->responseRedirectBack('Error occurred while updating Tertiary Category.', 'error', true, true);
        }
        return $this->responseRedirectBack('Tertiary Category has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $targetstate = $this->SubCategoryLevelRepository->deleteSubCategoryLevel($id);

        if (!$targetstate) {
            return $this->responseRedirectBack('Error occurred while deleting Tertiary Category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.sub-category-level2.index', 'Tertiary Category has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $targetstate = $this->SubCategoryLevelRepository->updateSubCategoryLevelStatus($params);

        if ($targetstate) {
            return response()->json(array('message'=>'Tertiary Category status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetsubcat = $this->SubCategoryLevelRepository->detailsSubCategoryLevel($id);
        $subcat = $targetsubcat[0];

        $this->setPageTitle('Tertiary Category', 'Tertiary Category Details : '.$subcat->title);
        return view('admin.subcategorylevel.details', compact('subcat'));
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
                    $count = 0;
                    // echo '<pre>';print_r($importData_arr);exit();

                    // Insert into database
                    foreach ($importData_arr as $importData) {
                        $commaSeperatedSubCats = '';
                        $catExistCheck = SubCategory::where('title', $importData[0])->first();
                            if ($catExistCheck) {
                                $insertDirCatId = $catExistCheck->id;
                                $commaSeperatedSubCats .= $insertDirCatId . ',';
                            } else {
                                $dirCat = new SubCategory();
                                $dirCat->title = $importData[0];
                                $dirCat->slug = null;
                                $dirCat->save();
                                $insertDirCatId = $dirCat->id;

                                $commaSeperatedSubCats .= $insertDirCatId . ',';
                            }

                                // slug generate
                                $slug = Str::slug($importData[1], '-');
                                $slugExistCount = DB::table('sub_categories')->where('title', $importData[1])->count();
                                if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
                        $insertData = array(
                            "title" => isset($importData[1]) ? $importData[1] : null,
                            "slug" => $slug,
                            "sub_category_id" => isset($commaSeperatedSubCats) ? $commaSeperatedSubCats : null,
                            "description" => isset($importData[2]) ? $importData[2] : null,
                        );
                        // echo '<pre>';print_r($insertData);exit();
                        $resp =  SubCategoryLevel::insertData($insertData,$count);
                        $count = $resp['count'];
                    }
                    if($count == 0){
                        FacadesSession::flash('csv', 'Already Uploaded. ');
                    } else{
                        FacadesSession::flash('csv', 'Import Successful. '.$count.' Data Uploaded');
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
        return redirect()->route('admin.sub-category-level2.index');
    }
    public function export(Request $request)
    {
        //return Excel::download(new CategoryExport, 'category.xlsx');
        if (!empty($request->term)) {
            $data = $this->SubCategoryLevelRepository->getSearchSubcategorylevel($request->term);
        } else {
            $data =  SubCategoryLevel::orderBy('title')->get();
        }

        if (($data)) {
            $delimiter = ",";
            $filename = "tertiary-category".".xlsx";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Set column headers 
            $fields = array('SR','Title',  'Sub Category','Description','Status','Created at');
            fputcsv($f, $fields, $delimiter); 

            $count = 1;

            foreach($data as $row) {
               
                $datetime = date('j M Y g:i A', strtotime($row['created_at']));
                $lineData = array(
                    $count,
                    $row['title'] ?? '',
                    $row->subcategory->title,
                    strip_tags($row->description),
                    ($row->status == 1) ? 'Active' : 'Blocked',
                    $datetime
                );

                fputcsv($f, $lineData, $delimiter);

                $count++;
            }

            // Move back to beginning of file
            fseek($f, 0);

            // Set headers to download file rather than displayed
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer
            fpassthru($f);
        }
    }
    
}
