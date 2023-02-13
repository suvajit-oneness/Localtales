<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Query;
use App\Models\QueryCatagory;
use Illuminate\Http\Request;

class QueryCatagoryController extends Controller
{
    public function index()
    {
        $data = QueryCatagory::all();
        return view('admin.queryCatagory.index', compact('data'));
    }
    public function create()
    {
        return view('admin.queryCatagory.create');
    }

    public function store(Request $request)
    {
        if (str_contains($request->name, ',')) {
            $string = explode(',', $request->name);
            foreach ($string as $value) {
                QueryCatagory::insert(['name' => $value]);
            }
        } else
            QueryCatagory::insert(['name' => $request->name]);
        return back()->with(array('message' => 'New Catagory created!'));
    }

    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $target = QueryCatagory::where('id', $params['id'])->update(['status' => $params['check_status']]);

        if ($target) {
            return response()->json(array('message' => 'status has been successfully updated'));
        }
    }

    public function delete($id)
    {
        QueryCatagory::where('id', $id)->delete();
        return back();
    }
}
