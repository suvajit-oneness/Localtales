<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\DemoImageContract;
use App\Http\Controllers\BaseController;
use App\Models\DemoImage;
use Session;
use Illuminate\Support\Str;


class DemoImageController extends BaseController
{
    /**
     * @var DemoImageContract
     */
    protected $DemoImageRepository;


    /**
     * PageController constructor.
     * @param DemoImageContract $categoryRepository
     */
    public function __construct(DemoImageContract $DemoImageRepository)
    {
        $this->DemoImageRepository = $DemoImageRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        $demo=DemoImage::orderby('title')->get();
        $this->setPageTitle('Placeholder Image', 'List of all Images');
        return view('admin.demo-image.index',compact('demo'));
    }

    public function create()
    {
        $this->setPageTitle('Placeholder Image', 'Create Demo Image');
        return view('admin.demo-image.create');
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
            'image'      =>  'required',

        ]);
        $params = $request->except('_token');

        $demo = $this->DemoImageRepository->createDemoImage($params);

        if (!$demo) {
            return $this->responseRedirectBack('Error occurred while creating Images.', 'error', true, true);
        }
        return $this->responseRedirect('admin.demo-image.index', 'Image has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $demo = $this->DemoImageRepository->findDemoImageById($id);

        $this->setPageTitle('Placeholder', 'Edit Image : ' . $demo->title);
        return view('admin.demo-image.edit', compact('demo'));
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
        $params = $request->except('_token');

        $category = $this->DemoImageRepository->updateDemoImage($params);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while updating Image.', 'error', true, true);
        }
        return $this->responseRedirectBack('Image has been updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $category = $this->DemoImageRepository->deleteDemoImage($id);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while deleting Image.', 'error', true, true);
        }
        return $this->responseRedirect('admin.demo-image.index', 'Image has been deleted successfully', 'success', false, false);
    }

    
}
