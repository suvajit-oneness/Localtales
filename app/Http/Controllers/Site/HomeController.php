<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Contracts\EventContract;
use App\Contracts\CategoryContract;
use App\Contracts\DealContract;
use App\Contracts\BusinessContract;
use App\Contracts\LoopContract;
use App\Contracts\BlogContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Auth;

class HomeController extends BaseController
{
	/**
     * @var EventContract
     */
    protected $eventRepository;
	/**
     * @var DealContract
     */
    protected $dealRepository;
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;
    /**
     * @var BusinessContract
     */
    protected $businessRepository;
    /**
     * @var LoopContract
     */
    protected $loopRepository;
    /**
     * @var BlogContract
     */
    protected $blogRepository;

	/**
     * HomeController constructor.
     * @param EventContract $eventRepository
     * @param DealContract $dealRepository
     * @param CategoryContract $categoryRepository
     * @param BusinessContract $businessRepository
     * @param LoopContract $loopRepository
     * @param BlogContract $blogRepository
     */
    public function __construct(EventContract $eventRepository, DealContract $dealRepository, CategoryContract $categoryRepository, BusinessContract $businessRepository,
    LoopContract $loopRepository,BlogContract $blogRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->dealRepository = $dealRepository;
        $this->categoryRepository = $categoryRepository;
        $this->businessRepository = $businessRepository;
        $this->loopRepository = $loopRepository;
        $this->blogRepository = $blogRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index(){
		$pinCode = '3000';

		$deals = $this->dealRepository->getTrendingDealsByPinCode($pinCode);
		$events = $this->eventRepository->getEventsByPinCode($pinCode);
        $businesses = $this->businessRepository->getTrendingBusinessByPinCode($pinCode);
		$categories = $this->categoryRepository->listCategories();
		
		$loops = $this->loopRepository->getLoops();
		$latestBlogs = $this->blogRepository->latestBlogs();

		$this->setPageTitle('Home', 'Home Page');
        return view('site.index' , compact('deals','events','pinCode','categories','businesses','loops','latestBlogs'));
	}

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request){
        $pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3000';
        $categoryId = (isset($request->category_id) && $request->category_id!='')?$request->category_id:'';
        $keyword = (isset($request->keyword) && $request->keyword!='')?$request->keyword:'';

        $deals = $this->dealRepository->searchDealsData($pinCode,$categoryId,$keyword);
        $events = $this->eventRepository->searchEventsData($pinCode,$categoryId,$keyword);
        $categories = $this->categoryRepository->listCategories();

        $this->setPageTitle('Search', 'Search Page');
        return view('site.search' , compact('deals','events','pinCode','categories','categoryId'));
    }
}