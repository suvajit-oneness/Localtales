<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\HelpCategoryContract;
use App\Http\Controllers\BaseController;
use App\Models\HelpCategory;
use Session;
use Illuminate\Support\Str;
use App\Exports\CategoryExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Illuminate\Support\Facades\Session as FacadesSession;
use Carbon\Carbon;
class HelpCategoryController extends BaseController
{
     /**
     * @var BlogCategoryContract
     */
    protected $HelpcategoryRepository;


    /**
     * PageController constructor.
     * @param HelpCategoryContract $HelpcategoryRepository
     */
    public function __construct(HelpCategoryContract $HelpcategoryRepository)
    {
        $this->HelpcategoryRepository = $HelpcategoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        $data =  HelpCategory::paginate(5);
        if (!empty($request->term)) {
            // dd($request->term);
            $categories = $this->HelpcategoryRepository->getSearchCategories($request->term);

            // dd($categories);
        } else {
            $categories = HelpCategory::latest('id')->paginate(20);
        }


        $this->setPageTitle('Category', 'List of all categories');
        return view('admin.help.category.index', compact('categories', 'data','request'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Category', 'Create category');
        return view('admin.help.category.create');
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

        ]);
        $slug = Str::slug($request->title, '-');
        $slugExistCount = HelpCategory::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

        // send slug
        request()->merge(['slug' => $slug]);

        $params = $request->except('_token');

        $category = $this->HelpcategoryRepository->createCategory($params);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.helpcategory.index', 'Category has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetCategory = $this->HelpcategoryRepository->findCategoryById($id);

        $this->setPageTitle('Category', 'Edit Category : ' . $targetCategory->title);
        return view('admin.help.category.edit', compact('targetCategory'));
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

        ]);
        $slug = Str::slug($request->title, '-');
        $slugExistCount = HelpCategory::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
        $params = $request->except('_token');

        $category = $this->HelpcategoryRepository->updateCategory($params);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while updating category.', 'error', true, true);
        }
        return $this->responseRedirectBack('Category has been updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $category = $this->HelpcategoryRepository->deleteCategory($id);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while deleting category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.helpcategory.index', 'Category has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {
        $category = HelpCategory::findOrFail($request->id);
        $category->status = $request->check_status;
        $category->save();

        return response()->json(array('message' => 'Category status has been successfully updated'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $categories = $this->HelpcategoryRepository->detailsCategory($id);
        $category = $categories[0];

        $this->setPageTitle('Category', 'Category Details : ' . $category->title);
        return view('admin.help.category.details', compact('category'));
    }


    //csv upload

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
                        $slug = Str::slug($importData[0], '-');
                        $slugExistCount = DB::table('help_categories')->where('title', $importData[0])->count();
                        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

                        $insertData = array(
                            "title" => isset($importData[0]) ? $importData[0] : null,
                            "description" => isset($importData[1]) ? $importData[1] : null,
                            "slug" => $slug,
                            "created_at" => Carbon::now(),
                            "updated_at"=> now(),
                        );
                        // echo '<pre>';print_r($insertData);exit();
                        $resp = HelpCategory::insertData($insertData,$count);
                        $count = $resp['count'];
                    }
                    if($count == 0){
                        FacadesSession::flash('csv', 'Already Uploaded. ');
                    } else{
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
        return redirect()->route('admin.helpcategory.index');
    }
    // csv upload

    // export
    public function export(Request $request)
    {
        //return Excel::download(new CategoryExport, 'helpcategory.xlsx');

        if (!empty($request->term)) {
            // dd($request->term);
            $data = $this->HelpcategoryRepository->getSearchCategories($request->term);

            // dd($categories);
        } else {
            $data = HelpCategory::latest('id')->paginate(20);
        }

        if (($data)) {
            $delimiter = ",";
            $filename = "category".".xlsx";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Set column headers 
            $fields = array('SR', 'Title', 'Description','Status', 'Created at');
            fputcsv($f, $fields, $delimiter); 

            $count = 1;

            foreach($data as $row) {
               
                $datetime = date('j M Y g:i A', strtotime($row['created_at']));
                $lineData = array(
                    $count,
                    $row['title'] ?? '',
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
    // export
}
