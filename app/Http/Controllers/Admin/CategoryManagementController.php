<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\BlogCategoryContract;
use App\Http\Controllers\BaseController;
use App\Models\BlogCategory;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Exports\CategoryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CategoryFaq;
use DB;
use Illuminate\Support\Facades\Session as FacadesSession;
class CategoryManagementController extends BaseController
{
    /**
     * @var BlogCategoryContract
     */
    protected $categoryRepository;


    /**
     * PageController constructor.
     * @param BlogCategoryContract $categoryRepository
     */
    public function __construct(BlogCategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        $data =  BlogCategory::paginate(5);
        if (!empty($request->term)) {
            // dd($request->term);
            $categories = $this->categoryRepository->getSearchCategories($request->term);

            // dd($categories);
        } else {
            $categories = BlogCategory::orderby('title')->paginate(20);
        }


        $this->setPageTitle('Category', 'List of all categories');
        return view('admin.category.index', compact('categories', 'data','request'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Category', 'Create category');
        return view('admin.category.create');
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
            'description' => 'required|max:500',
            'image' => 'required|image|max:200',
            'short_content' => 'nullable|string|min:1',
            'medium_content' => 'nullable|string|min:1',
            'long_content' => 'nullable|string|min:1',
            'medium_content_image' => 'nullable|image|max:200',
            'long_content_image' => 'nullable|image|max:200',
        ]);

        $slug = Str::slug($request->title, '-');
        $slugExistCount = BlogCategory::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

        // send slug
        request()->merge(['slug' => $slug]);
        $params = $request->except('_token');
        $category = $this->categoryRepository->createCategory($params);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.category.index', 'Category has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetCategory = $this->categoryRepository->findCategoryById($id);
        $faq = CategoryFaq::where('category_id',$id)->get();

        $this->setPageTitle('Category', 'Edit Category : ' . $targetCategory->title);
        return view('admin.category.edit', compact('targetCategory','faq'));
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
            'description' => 'required|max:500',
            'image' => 'nullable|image|max:200',
            'short_content' => 'nullable|string|min:1',
            'medium_content' => 'nullable|string|min:1',
            'long_content' => 'nullable|string|min:1',
            'medium_content_image' => 'nullable|image|max:200',
            'long_content_image' => 'nullable|image|max:200',
        ]);

        $slug = Str::slug($request->title, '-');
        $slugExistCount = BlogCategory::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
        $params = $request->except('_token');
        $category = $this->categoryRepository->updateCategory($params);

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
        $category = $this->categoryRepository->deleteCategory($id);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while deleting category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.category.index', 'Category has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $category = $this->categoryRepository->updateCategoryStatus($params);

        if ($category) {
            return response()->json(array('message' => 'Category status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $categories = $this->categoryRepository->detailsCategory($id);
        $category = $categories[0];

        $this->setPageTitle('Category', 'Category Details : ' . $category->title);
        return view('admin.category.details', compact('category'));
    }


    //csv upload

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
    //                 $count = $total = 0;
    //                 $successArr = $failureArr = [];
    //                 // Insert into database
    //                 foreach ($importData_arr as $importData) {
    //                     $storeData = 0;
                       
    //                     if (!empty($importData[0])) {
    //                         // dd($importData[0]);
    //                         $titleArr = explode(',', $importData[0]);

    //                         // echo '<pre>';print_r($titleArr);exit();

    //                         foreach ($titleArr as $titleKey => $titleValue) {
    //                             // slug generate
    //                             $slug = Str::slug($titleValue, '-');
    //                             $slugExistCount = DB::table('blog_categories')->where('title', $titleValue)->count();
    //                             if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
    //                         $insertData = array(
    //                         "title" => isset($importData[0]) ? $importData[0] : null,
    //                         "description" => isset($importData[1]) ? $importData[1] : null,
    //                         "short_content" => isset($importData[2]) ? $importData[2] : null,
    //                         "medium_content" => isset($importData[3]) ? $importData[3] : null,
    //                         "long_content" => isset($importData[4]) ? $importData[4] : null,
    //                         "slug" => $slug,

    //                     );
    //                     // echo '<pre>';print_r($insertData);exit();
    //                     BlogCategory::insertData($insertData, $count, $successArr, $failureArr);
    //                 }
    //               }
    //            }
    //             if($count == 0){
    //                 FacadesSession::flash('csv', 'Already Uploaded. ');
    //             } else{
    //                 FacadesSession::flash('csv', 'Import Successful. '.$count.' Data Uploaded');
    //             }
    //         } else {
    //             Session::flash('message', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
    //         }
    //     } else {
    //         Session::flash('message', 'No file found.');
    //     }
    //     return redirect()->route('admin.category.index');
    // }
    // csv upload
    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function csvStore(Request $request)
    {
        // dd($request->all());

        try {
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
                        $location = 'uploads/admin/csv';
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
                            // dd($num);
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
                        foreach ($importData_arr as $importData) {
                            $insertData = [];
                                
                                // slug generate
                                $slug = Str::slug($importData[0], '-');
                                $slugExistCount = DB::table('blog_categories')->where('title', $importData[0])->count();
                                if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
                                $insertData = array(
                                    "title" => isset($importData[0]) ? $importData[0] : null,
                                    "description" => isset($importData[1]) ? $importData[1] : null,
                                    "short_content" => isset($importData[2]) ? $importData[2] : null,
                                    "medium_content" => isset($importData[3]) ? $importData[3] : null,
                                    "long_content" => isset($importData[4]) ? $importData[4] : null,
                                    "slug" => $slug,
                                    "created_at" => Carbon::now(),
                                    "updated_at"=> now(),
                                   
                                );
                               
                                $resp = BlogCategory::insertData($insertData,$count);
                                $count = $resp['count'];
                                
                            }
                           
                    
                            if($count == 0){
                                FacadesSession::flash('csv', 'Already Uploaded. ');
                            } else{
                                 FacadesSession::flash('csv', 'Import Successful. '.$count.' Data Uploaded');
                            }
                        
                        //return redirect()->back()->with('message', 'Import Successful.');
                    } else {
                        FacadesSession::flash('csv', 'File too large. File must be less than 50MB.');
                    }
                } else {
                    FacadesSession::flash('csv', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
                }
            } else {
                FacadesSession::flash('csv', 'No file found.');
            }

            return redirect()->route('admin.category.index');
        } catch (\Exception $th) {
            return $th;
        }
    }
    // export
    public function export(Request $request)
    {
        //return Excel::download(new CategoryExport, 'category.xlsx');
        if (!empty($request->term)) {
            // dd($request->term);
            $data = $this->categoryRepository->getSearchCategories($request->term);

            // dd($categories);
        } else {
            $data = BlogCategory::orderby('title')->get();
        }

        if (($data)) {
            $delimiter = ",";
            $filename = "category".".xlsx";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Set column headers 
            $fields = array('SR', 'Title', 'Description','Short Content','Medium Content', 'Long Content','Status', 'Created at');
            fputcsv($f, $fields, $delimiter); 

            $count = 1;

            foreach($data as $row) {
               
                $datetime = date('j M Y g:i A', strtotime($row['created_at']));
                $lineData = array(
                    $count,
                    $row['title'] ?? '',
                    strip_tags($row->description),
                    strip_tags($row->short_content),
                    strip_tags($row->medium_content),
                    strip_tags($row->long_content),
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
