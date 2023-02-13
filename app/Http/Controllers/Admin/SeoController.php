<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoManagement;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
class SeoController extends BaseController
{
    public function index(Request $request){
        $seo=SeoManagement::all();
        return view('admin.seo.index', compact('seo'));
    }

    public function edit($id)
    {
        // $targetCategory = $this->DirectoryCategoryRepository->finddirectoryCategoryById($id);
        $seo = SeoManagement::findOrFail($id);
        $this->setPageTitle('SEO', 'Edit SEO : ' . $seo->title);
        return view('admin.seo.edit', compact('seo'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:1|max:255',
        ]);

        $seo = SeoManagement::findOrFail($request->id);
        $seo->page = !empty($request->page) ? $request->page : '';
        $seo->title = !empty($request->title) ? $request->title : '';
        $seo->meta_desc = !empty($request->meta_desc) ? $request->meta_desc : '';
        $seo->save();
        return $this->responseRedirect('admin.seo.index', 'SEO edited successfully', 'success', false, false);
}

public function details($id)
    {
        $seo=SeoManagement::where('id',$id)->get();
        $data = $seo[0];

        $this->setPageTitle('SEO', 'SEO Details : '.$data->title);
        return view('admin.seo.details', compact('data'));
    }
}
