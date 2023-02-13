<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\QueryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class QueryController extends Controller
{
    public function __construct(QueryContract $QueryRepository)
    {
        $this->QueryRepository = $QueryRepository;
    }
    public function index()
    {
        $data = $this->QueryRepository->listAllQuery();
        return view('admin.query.index', compact('data'));
    }
    public function detail($id)
    {
        $data = $this->QueryRepository->viewQuery($id);
        return view('admin.query.details', compact('data'));
    }
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $target = $this->QueryRepository->updateQueryStatus($params);

        if ($target) {
            return response()->json(array('message' => 'status has been successfully updated'));
        }
    }
    public function delete($id)
    {
        $this->QueryRepository->deleteQuery($id);
        return back();
    }
}
