<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Directory;

class DirectoryController extends BaseController
{
    public function index(Request $request)
    {
        $this->setPageTitle('Directory', 'List of all Directory');
        $value = $_COOKIE['postcode'] ?? '';
        $directory = Directory::where('address','LIKE','%' . $value)->paginate(18);

        if (isset($request->code) || isset($request->keyword) || isset($request->name)) {
            // dd($request->all());
            $category = $request->directory_category;
            $code = $request->code;
            $keyword = $request->keyword;
            $type = $request->type;
            $name = $request->name;

            if (!empty($keyword)) {
                $directoryList = DB::table('directories')->whereRaw("address like '%$keyword'")->paginate(18)->appends(request()->query());
            }
            if (!empty($name)) {
                $name = addslashes($name);
                $directoryList = DB::table('directories')->whereRaw("name like '%$name%'")->paginate(18)->appends(request()->query());
            }

            if (!empty($code)) {
                // if primary category
                if ($type == "primary") {
                    $keywordQuery = "AND name like '%$name%' ";
                    $directoryList = DB::table('directories')->whereRaw("address like '%$keyword' $keywordQuery and
                    ( category_id like '$request->code,%' or category_id like '%,$request->code,%' or category_tree like '%$request->directory_category%')")->paginate(18)->appends(request()->query());
                } elseif ($type == "secondary") {
                    $keywordQuery = "AND name like '%$name%' ";
                    $directoryList = DB::table('directories')->whereRaw("address like '%$keyword' $keywordQuery and
                    ( category_id like '$request->code,%' or category_id like '%,$request->code,%' or category_tree like '%$request->directory_category%')")->paginate(18)->appends(request()->query());
                }
            }
        } else {
            if(count($directory)>0){
                $directoryList = Directory::where('address','LIKE','%' . $value)->paginate(18)->appends(request()->query());
            } else {
                $directoryList = Directory::paginate(18)->appends(request()->query());
            }
        }

        return view('site.business.index3', compact('directoryList'));
    }
}
