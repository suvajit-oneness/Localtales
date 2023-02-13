<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryFaq;
use App\Contracts\CategoryFaqContract;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Illuminate\Support\Facades\Session as FacadesSession;
class CategoryFaqManagementController extends BaseController
{
    protected $CategoryFaqRepository;

    /**
     * BlogController constructor.
     * @param BlogFaqRepository $BlogRepository
     */

    public function __construct(CategoryFaqContract $CategoryFaqRepository)
    {
        $this->CategoryFaqRepository = $CategoryFaqRepository;

    }

    /**
     * List all the states
     */
    public function index(Request $request,$id)
    {
        $faq = $this->CategoryFaqRepository->listFaqs();
        $this->setPageTitle('Category Faq', 'List of all Article Category');
        return view('admin.category.categoryfaq.index', compact('faq','request'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.category.categoryfaq.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'question' => 'required|string|min:1',
            'answer' => 'required|string|min:1',
        ]);

        $blog = $this->CategoryFaqRepository->createFaq($request->except('_token'));

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while creating Category Faq.', 'error', true, true);
        }
        return $this->responseRedirectBack('Category Faq has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetfaq = $this->CategoryFaqRepository->findFaqById($id);
        $this->setPageTitle('Category Faq', 'Edit Category Faq : ' . $targetfaq->title);
        return view('admin.category.categoryfaq.edit', compact('targetfaq'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $request->validate([
            'question' => 'required|string|min:1',
            'answer' => 'required|string|min:1',
        ]);
        $params = $request->except('_token');

        $targetblog = $this->CategoryFaqRepository->updateFaq($params);

        if (!$targetblog) {
            return $this->responseRedirectBack('Error occurred while updating Category Faq.', 'error', true, true);
        }
        return $this->responseRedirectBack('Category Faq has been updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $targetblog = $this->CategoryFaqRepository->deleteFaq($id);

        if (!$targetblog) {
            return $this->responseRedirectBack('Error occurred while deleting Category Faq.', 'error', true, true);
        }
        return $this->responseRedirectBack('Category Faq has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $targetblog = $this->CategoryFaqRepository->updateFaqStatus($params);

        if ($targetblog) {
            return response()->json(array('message' => 'Category Faq status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetfaq = $this->CategoryFaqRepository->detailsFaq($id);
        $faq = $targetfaq[0];
        $this->setPageTitle('Category Faq', 'Category faq Details : ' . $faq->title);
        return view('admin.category.categoryfaq.details', compact('faq'));
    }

}

