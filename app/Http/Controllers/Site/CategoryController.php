<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\DirectoryCategory;

class CategoryController extends BaseController
{

    public function index(Request $request)
    {
        $this->setPageTitle('Faq', 'Local Tales Category');
        $allCategories = DirectoryCategory::where('status', 1)->where('parent_category', '!=', null)->where('type', 1)->orderBy('parent_category')->get();

        if (!empty($request->title)) {
            $data = DirectoryCategory::where('type', 1)->where('status', 1)->where('parent_category', 'like', '%'.$request->title.'%')->where('parent_category','!=','adult')->orderBy('parent_category')->paginate(12);
        } else {
            $data = DirectoryCategory::where('type', 1)->where('status', 1)->orderBy('parent_category')->paginate(12);
        }

        return view('site.category.home', compact('allCategories', 'data'));
    }

    public function detail(Request $request, $slug)
    {
        $this->setPageTitle('Category', 'Local Tales');

        // DONOT use first() here, use get()
        $data = DirectoryCategory::where('parent_category_slug', $slug)->where('type', 1)->get();

        if (count($data) > 0) {
            $type = 'primary';

            $relatedCategories = DirectoryCategory::where('parent_category_slug', '!=', $slug)->where('type', 1)->where('status', 1)->orderby('parent_category')->get();

            // sub categories
            $childCategories = DirectoryCategory::where('parent_category', $data[0]->parent_category)->where('type', 0)->distinct()->paginate(16);
            $childCategoriesGrouped = DirectoryCategory::where('parent_category', $data[0]->parent_category)->where('type', 0)->orderBy('child_category')->groupBy('child_category')->distinct()->paginate(16);

            // directories
            $directoryList = '';
        } else {
            $type = 'secondary';
            $data = DirectoryCategory::where('child_category_slug', $slug)->where('type', 0)->get();
            $relatedCategories = '';

            // sub categories
            $childCategories = '';
            $childCategoriesGrouped = '';

            // updates for banks category only
            if ($slug == 'banks') {
                // dd('here');
                DB::enableQueryLog();

                $directoryList = DB::table('directory_categories')
                ->select('*')
                ->join('directories', 'directories.category_id', '=', 'directory_categories.id')
                ->whereRaw("child_category_slug = '$slug' AND (category_id = '1080,' OR category_id = '1285,' OR category_id = '1412,' OR category_id = '1472,' OR category_id = '1618,' OR category_id = '1619,' OR category_id = '1838,' OR category_id = '1853,' OR category_id = '2110,')")
                ->paginate(18);
            } else {
                $directoryList = DB::table('directory_categories')
                ->select('*')
                ->join('directories', 'directories.category_id', '=', 'directory_categories.id')
                ->where('directory_categories.child_category_slug', $slug)
                ->paginate(18);
            }
        }
        if($data){
            return view('site.category.index', compact('data', 'type', 'relatedCategories', 'childCategories', 'childCategoriesGrouped', 'directoryList'));
        } else {
            return view('site.404');
        }
    }

}
