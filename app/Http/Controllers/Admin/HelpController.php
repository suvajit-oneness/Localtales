<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\HelpContract;
use App\Contracts\HelpCategoryContract;
use App\Models\HelpArticle;
use App\Models\ActivityLogCsv;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PinCodeExport;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Session as FacadesSession;

class HelpController extends BaseController
{
    protected $BlogRepository;

    /**
     * BlogController constructor.
     * @param BlogRepository $BlogRepository
     */

    public function __construct(HelpContract $HelpRepository, HelpCategoryContract $directoryCategoryRepository)
    {
        $this->HelpRepository = $HelpRepository;
        $this->directoryCategoryRepository = $directoryCategoryRepository;
    }

    /**
     * List all the states
     */
    public function index(Request $request)
    {
        
        if (!empty($request->term)) {
            // dd($request->term);
            $blogs = $this->HelpRepository->getSearchBlog($request->term);

            // dd($categories);
        } else {
            $blogs = HelpArticle::latest('id')->paginate(25);
        }
        $this->setPageTitle('Article', 'List of all Article');
        return view('admin.help.index', compact('blogs'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Article', 'Create Article');
        // $blogcat = $this->BlogRepository->getBlogcategories();
        $blogcat = $this->HelpRepository->getBlogcategories();
        $blogsubcat = $this->HelpRepository->getBlogsubcategories();
        return view('admin.help.create', compact('blogcat', 'blogsubcat'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:1',
            'description' => 'required|string',
        ]);

        $blog = $this->HelpRepository->createBlog($request->except('_token'));

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while creating Article.', 'error', true, true);
        }
        return $this->responseRedirect('admin.userhelp.index', 'Article has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetblog = $this->HelpRepository->findBlogById($id);
        $blogcat = $this->HelpRepository->getBlogcategories('title', 'asc');
        $blogsubcat = $this->HelpRepository->getBlogsubcategories();
        
        $this->setPageTitle('Article', 'Edit Article : ' . $targetblog->title);
        return view('admin.help.edit', compact('targetblog', 'blogcat', 'blogsubcat'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:1',
            'description' => 'required|string',
        ]);
        // $slug = Str::slug($request->name, '-');
        // $slugExistCount = Blog::where('slug', $slug)->count();
        // if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
        $params = $request->except('_token');

        $targetblog = $this->HelpRepository->updateBlog($params);

        if (!$targetblog) {
            return $this->responseRedirectBack('Error occurred while updating Article.', 'error', true, true);
        }
        return $this->responseRedirectBack('Article has been updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $targetblog = $this->HelpRepository->deleteBlog($id);

        if (!$targetblog) {
            return $this->responseRedirectBack('Error occurred while deleting Article.', 'error', true, true);
        }
        return $this->responseRedirect('admin.userhelp.index', 'Article has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $targetblog = $this->HelpRepository->updateBlogStatus($params);

        if ($targetblog) {
            return response()->json(array('message' => 'Article status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetblog = $this->HelpRepository->detailsBlog($id);
        $blog = $targetblog[0];

        $this->setPageTitle('Article', 'Article Details : ' . $blog->title);
        return view('admin.help.details', compact('blog'));
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

                        $commaSeperatedCats = '';
                        
                            $catExistCheck = HelpCategory::where('title', $importData[2])->first();
                            if ($catExistCheck) {
                                $insertDirCatId = $catExistCheck->id;
                                $commaSeperatedCats .= $insertDirCatId . ',';
                            } else {
                                $dirCat = new BlogCategory();
                                $dirCat->title = $importData[2];
                                $dirCat->slug = null;
                                $dirCat->save();
                                $insertDirCatId = $dirCat->id;

                                $commaSeperatedCats .= $insertDirCatId . ',';
                            }
                        
                        $count = 0;
                        $commaSeperatedSubCats = '';
                         $count = $total = 0;
                        $successArr = $failureArr = [];
                        
                            $catExistCheck = SubCategory::where('title', $importData[3])->first();
                            if ($catExistCheck) {
                                $insertDirCatId = $catExistCheck->id;
                                $commaSeperatedSubCats .= $insertDirCatId . ',';
                            } else {
                                $dirCat = new SubCategory();
                                $dirCat->title = $importData[3];
                                $dirCat->slug = null;
                                $dirCat->save();
                                $insertDirCatId = $dirCat->id;

                                $commaSeperatedSubCats .= $insertDirCatId . ',';
                            }
                        
 			     $commaSeperatedSublevelCats = '';
                           
                            $catExistCheck = HelpSubCategoryLevel::where('title', $importData[4])->first();
                            if ($catExistCheck) {
                                $insertDirCatId = $catExistCheck->id;
                                $commaSeperatedSublevelCats .= $insertDirCatId . ',';
                            } else {
                                $dirCat = new SubCategoryLevel();
                                $dirCat->title = $importData[4];
                                $dirCat->slug = null;
                                $dirCat->save();
                                $insertDirCatId = $dirCat->id;

                                $commaSeperatedSublevelCats .= $insertDirCatId . ',';
                            }
                        
                        if (!empty($importData[9])) {
                            // dd($importData[0]);
                            $titleArr = explode(',', $importData[9]);

                            // echo '<pre>';print_r($titleArr);exit();

                            foreach ($titleArr as $titleKey => $titleValue) {
                                // slug generate
                                $slug = Str::slug($titleValue, '-');
                                $slugExistCount = DB::table('blogs')->where('title', $titleValue)->count();
                                if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

                                $insertData = array(
                                    "title" => $titleValue,
                                    "content" => isset($importData[7]) ? $importData[7] : null,
                                    "meta_title" => isset($importData[8]) ? $importData[8] : null,
                                    "meta_key" => isset($importData[6]) ? $importData[6] : null,
                                    "blog_category_id" => isset($commaSeperatedCats) ? $commaSeperatedCats : null,
                                    "blog_sub_category_id" => isset($commaSeperatedSubCats) ? $commaSeperatedSubCats : null,
                                    "blog_tertiary_category_id" => isset($commaSeperatedSublevelCats) ? $commaSeperatedSublevelCats : null,
                                    "slug" => $slug,
                                    "meta_description" => isset($importData[8]) ? $importData[8] : null,

                                );

                                $resp =HelpArticle::insertData($insertData, $count,$successArr,$failureArr);
                                $count = $resp['count'];
                                $successArr = $resp['successArr'];
                                $failureArr = $resp['failureArr'];
                                $total++;
                            }
                        }
                    }
                    //Session::flash('message', 'Import Successful.');
                        $store = new ActivityLogCsv;
                        $store->user_id =  Auth::guard('admin')->user()->id;
                        $store->csv_file_location = $location . "/" . $filename;
                        $store->total_rows = $total;
                        $store->success_count = $count;
                        $store->success_array = (count($resp['successArr']) > 0) ? json_encode($resp['successArr']) : '';
                        $store->failure_count = $total - $count;
                        $store->failure_array = (count($resp['failureArr']) > 0) ? json_encode($resp['failureArr']) : '';
                        $store->csv_type = 'article';
                        $store->save();
                    if($count==0){
                            FacadesSession::flash('csv', 'Already Uploaded. ');
                        }
                        else{
                             FacadesSession::flash('csv', 'Import Successful. '.$count.' Data Uploaded');
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
        return redirect()->route('admin.userhelp.index');
    }
    // csv upload

    public function export()
    {
        return Excel::download(new BlogExport, 'blog.xlsx');
    }
     public function csv(Request $request)
    {
        $csv= ActivityLogCsv::latest('id')->paginate(25);
        $this->setPageTitle('CSV Activity', 'List of all CSV Activity');
        return view('admin.csv-activity.index', compact('csv'));
    }
    

}
