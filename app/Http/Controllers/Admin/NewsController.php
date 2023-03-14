<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\NewsContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\News;
use App\Models\State;
use App\Models\PinCode;

class NewsController extends BaseController
{
    /**
     * @var NewsContract
     */
    protected $NewsRepository;

    /**
     * PageController constructor.
     * @param NewsContract $NewsRepository
     */
    public function __construct(NewsContract $NewsRepository)
    {
        $this->NewsRepository = $NewsRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        if (!empty($request->term)) {
            $news = $this->NewsRepository->getSearchNews($request->term);
        } else {
            $news = News::latest('id')->paginate(25);
        }
        $this->setPageTitle('News', 'List of all News');
        return view('admin.news.index', compact('news'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $state=State::orderby('name')->get();
        $pin=PinCode::orderby('pin')->get();
        $this->setPageTitle('News', 'Create News');
        return view('admin.news.create',compact('pin','state'));
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

        $params = $request->except('_token');
        
        $news = $this->NewsRepository->createNews($params);

        if (!$news) {
            return $this->responseRedirectBack('Error occurred while creating News.', 'error', true, true);
        }
        return $this->responseRedirect('admin.news.index', 'News has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetNews = $this->NewsRepository->findNewsById($id);
        $state=State::orderby('name')->get();
        $pin=PinCode::orderby('pin')->get();
        $this->setPageTitle('News', 'Edit News : '.$targetNews->title);
        return view('admin.news.edit', compact('targetNews','pin','state'));
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

        $news = $this->NewsRepository->updateNews($params);

        if (!$news) {
            return $this->responseRedirectBack('Error occurred while updating news.', 'error', true, true);
        }
        return $this->responseRedirectBack('News has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $news = $this->NewsRepository->deleteNews($id);

        if (!$news) {
            return $this->responseRedirectBack('Error occurred while deleting News.', 'error', true, true);
        }
        return $this->responseRedirect('admin.news.index', 'News has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $news = $this->NewsRepository->updateNewsStatus($params);

        if ($news) {
            return response()->json(array('message'=>'News status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $News = $this->NewsRepository->detailsNews($id);
        $data = $News[0];

        $this->setPageTitle('News', 'News Details : '.$data->title);
        return view('admin.news.details', compact('data'));
    }
}
