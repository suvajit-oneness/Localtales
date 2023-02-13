<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\EventContract;
use App\Contracts\CategoryContract;
use App\Contracts\DealContract;
use App\Contracts\BusinessContract;
use App\Contracts\NotificationContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\BlogCategory;
use App\Models\SubCategory;
use App\Models\SubCategoryLevel;
use Auth;
use DB;
class ApiController extends BaseController
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
     * @var NotificationContract
     */
    protected $notificationRepository;
    /**
     * @var BusinessContract
     */
    protected $businessRepository;

	/**
     * PageController constructor.
     * @param EventContract $eventRepository
     * @param DealContract $dealRepository
     * @param CategoryContract $categoryRepository
     * @param NotificationContract $notificationRepository
     */
    public function __construct(EventContract $eventRepository, DealContract $dealRepository, CategoryContract $categoryRepository, NotificationContract $notificationRepository, BusinessContract $businessRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->dealRepository = $dealRepository;
        $this->categoryRepository = $categoryRepository;
        $this->notificationRepository = $notificationRepository;
        $this->businessRepository = $businessRepository;

    }

    /**
     * This method is for getting all category list
	 * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(){
    	$categories = $this->categoryRepository->listCategories();

    	return response()->json(compact('categories'));
    }

    /**
     * This method is for getting event and deals list pin code wise in home page
     * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
     */
    public function getAllHomeData(Request $request){
    	$pinCode = (isset($request->pin) && $request->pin!='')?$request->pin:'3000';
        $categoryId = (isset($request->category_id) && $request->category_id!='')?$request->category_id:'';
        $keyword = (isset($request->keyword) && $request->keyword!='')?$request->keyword:'';

        $deals = $this->dealRepository->searchDealsData($pinCode,$categoryId,$keyword);
        $events = $this->eventRepository->searchEventsData($pinCode,$categoryId,$keyword);
        $businesses = $this->businessRepository->getTrendingBusinessByPinCode($pinCode);
        $categories = $this->categoryRepository->listCategories();

        return response()->json(compact('deals','events','businesses','categories'));
    }

    /**
     * This method is for getting notification data
     * @return \Illuminate\Http\JsonResponse
     */
    public function notifications(){
        $notifications = $this->notificationRepository->listNotifications();

        return response()->json(compact('notifications'));
    }

    /**
     * This method is for getting user's saved data
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserSavedData($user_id){
        $userDeals = $this->dealRepository->userDeals($user_id);
        $userEvents = $this->eventRepository->userEvents($user_id);
        $UserBusinesses = $this->businessRepository->UserBusinesses($user_id);

        $events = array();
        $deals = array();
        $businesses = array();

        foreach($userEvents as $userEvent){
            array_push($events, $userEvent->event);
        }

        foreach($userDeals as $userDeal){
            array_push($deals, $userDeal->deal);
        }

        foreach($UserBusinesses as $UserBusiness){
            array_push($businesses, $UserBusiness->business);
        }

        return response()->json(compact('events','deals','businesses'));
    }


    public function categorywiseSubcategory($id="")
    {

        if ($id != "100000") {
            $cat = DB::select("SELECT title AS cat_name FROM  blog_categories WHERE id = ".$id);

            $cat_name = $cat[0]->cat_name;
            $subCat = DB::select("SELECT id, title  FROM `sub_categories` WHERE category_id = ".$id." ORDER BY title ASC");
        } else {
            $cat_name = 'all';
            $subCat = DB::select("SELECT p.id, p.title AS title FROM `sub_categories` AS p INNER JOIN blog_categories AS c ON p.category_id = c.id ORDER BY c.title ASC, p.title ASC;");
        }

		$resp = [
            'cat_name' => $cat_name,
            'subcategory' => [],
        ];

        foreach($subCat as $cat) {
            $resp['subcategory'][] = [
                'subcategory_id' => $cat->id,
                'subcategory_title' => $cat->title,

            ];
        }
        return response()->json(['error' => false, 'message' => 'Category wise SubCategory  list', 'data' => $resp]);
    }


    //subcategory wise tertiary category

    public function subcategorywiseTertiarycategory($id="")
    {

        if ($id != "100000") {
            $cat = DB::select("SELECT title AS subcat_name FROM  sub_categories WHERE id = ".$id);

            $cat_name = $cat[0]->subcat_name;
            $tertiaryCat = DB::select("SELECT id, title  FROM `sub_category_levels` WHERE sub_category_id = ".$id." ORDER BY title ASC");
        } else {
            $cat_name = 'all';
            $tertiaryCat = DB::select("SELECT p.id, p.title AS title FROM `sub_category_levels` AS p INNER JOIN sub_categories AS c ON p.sub_category_id = c.id ORDER BY c.title ASC, p.title ASC;");
        }

		$resp = [
            'cat_name' => $cat_name,
            'tertiarycategory' => [],
        ];

        foreach($tertiaryCat as $cat) {
            $resp['tertiarycategory'][] = [
                'tertiarycategory_id' => $cat->id,
                'tertiarycategory_title' => $cat->title,

            ];
        }
        return response()->json(['error' => false, 'message' => 'SubCategory wise TertiaryCategory  list', 'data' => $resp]);
    }

    //postcode wise suburb

    public function postcodewiseSuburb($postcode="")
    {

        if ($postcode != "") {
            $zipcode = DB::select("SELECT pin AS postcode FROM  pin_codes WHERE pin = ".$postcode);
            //dd($zipcode);
            $postcode_name = $zipcode[0]->postcode;
            $suburb = DB::select("SELECT id, name  FROM `suburbs` WHERE pin_code = ".$postcode." ORDER BY name ASC");
        } else {
            $postcode_name = 'all';
            $suburb = DB::select("SELECT p.id, p.name AS name FROM `suburbs` AS p INNER JOIN pin_codes AS c ON p.pin_code = c.pin ORDER BY c.pin ASC, p.name ASC;");
        }

		$resp = [
            'postcode' => $postcode_name,
            'suburb' => [],
        ];

        foreach($suburb as $cat) {
            $resp['suburb'][] = [
                'suburb_id' => $cat->id,
                'suburb_title' => $cat->name,
            ];
        }
        return response()->json(['error' => false, 'message' => 'Postcode wise Suburb  list', 'data' => $resp]);
    }

    public function index(Request $request)
    {

		    $keyword = $request->data;
			//dd($keyword);
			$cat_level1 = DB::table('blog_categories')->where('title', 'like', '%'.$keyword.'%')->limit(10)->get();
			$cat_level2 = DB::table('sub_categories')->where('title', 'like', '%'.$keyword.'%')->limit(10)->get();
			$cat_level3 = DB::table('sub_category_levels')->where('title', 'like', '%'.$keyword.'%')->limit(10)->get();

			$resp =  [];
			if (count($cat_level1) > 0) {
			    foreach($cat_level1 as $value) {
				$secondaryCategoriesGrouped = DB::table('sub_categories')->select('id', 'title')->where('category_id', $value->id)->groupBy('title')->limit(25)->get();

				$resp[] = [
				    'type' => 'primary',
				    'id' => $value->id,
				    'title' => $value->title,
				    'child' => $secondaryCategoriesGrouped
				];
			    }
			}

			if (count($cat_level2) > 0) {
			    foreach($cat_level2 as $value) {
				$tertiaryCategoriesGrouped = DB::table('sub_category_levels')->select('id', 'title')->where('sub_category_id', $value->id)->groupBy('title')->limit(25)->get();

				$resp[] = [
				    'type' => 'secondary',
				    'id' => $value->id,
				    'tertiary_category_id' =>$value->id,
				    'title' => $value->title,
				    'child' => $tertiaryCategoriesGrouped
				];
			    }
			}
			if (count($cat_level3) > 0) {
			    foreach($cat_level3 as $value) {
				$resp[] = [
				    'type' => 'tertiary',
				    'id' => $value->id,
				    'tertiary_category_id' =>$value->id,
				    'title' => $value->title,
				    'child' => ''
				];
			    }
			}

        /*$keyword = $request->code;

        $cat_level1 = DB::table('blog_categories')->where('title', 'like', '%'.$keyword.'%')->limit(6)->get();
        $cat_level2 = DB::table('sub_categories')->where('title', 'like', '%'.$keyword.'%')->limit(6)->get();
        $cat_level3 = DB::table('sub_category_levels')->where('title', 'like', '%'.$keyword.'%')->limit(6)->get();

        $resp = $resp1 = $resp2 = $resp3 = [];

        if ($cat_level1->count() > 0 || $cat_level2->count() > 0 || $cat_level3->count() > 0) {
            foreach($cat_level1 as $value) {
                $resp1[] = [
                    'id' => $value->id,
                    'title' => $value->title,
                    'type'  => 'cat_level1',
                ];
            }

            if ($cat_level2->count() > 0) {
                foreach($cat_level2 as $value) {
                    $resp2[] = [
                        'id' => $value->id,
                        'title' => $value->title,
                        'type'  => 'cat_level2',
                    ];
                }
            }

            if ($cat_level3->count() > 0) {
                foreach($cat_level3 as $value) {
                    $resp3[] = [
                        'id' => $value->id,
                        'title' => $value->title,
                        'type'  => 'cat_level3',
                    ];
                }
            }

            $resp[] = [
                'cat1' => $resp1,
                'cat2' => $resp2,
                'cat3' => $resp3
            ];
        }*/
        /* else {
            if ($cat_level2->count() > 0) {
                foreach($cat_level2 as $value) {
                    $resp[] = [
                        'id' => $value->id,
                        'title' => $value->title,
                        'type'  => 'cat_level2',
                    ];
                }
            } else {
                if ($cat_level3->count() > 0) {
                    foreach($cat_level3 as $value) {
                        $resp[] = [
                            'id' => $value->id,
                            'title' => $value->title,
                            'type'  => 'cat_level3',
                        ];
                    }
                }
            }
        } */

        if (count($resp) > 0) {
            return response()->json(['error' => false, 'message' => 'Details found', 'data' => $resp]);
        } else {
            return response()->json(['error' => true, 'message' => 'No details found. Try again!']);
        }

        /* $categoryData=DB::select("SELECT p.id, p.title AS subcategory_title, c.title AS title FROM `sub_categories` AS p INNER JOIN blog_categories AS c ON p.category_id = c.id where c.title LIKE '".$request->code."'
        ");
        dd($categoryData);

        $subCategoryData = SubCategory::where("title", "LIKE", "%".$request->code."%")->limit(15)->get();
        $tertiaryCategoryData = SubCategoryLevel::where("title", "LIKE", "%".$request->code."%")->limit(6)->get();

        $resp = [];

        if ($categoryData->count() > 0) {
            foreach ($categoryData as $key => $value) {
                $resp[] = [
                    'title' => $value->title,
                    'type'  => 'category',

                ];
            }
        }
        if ($subCategoryData->count() > 0) {
            foreach ($subCategoryData as $key => $value) {


                $resp[] = [
                    // 'pin' => $firstPin->pin,
                    'pin' => '',
                    'subcategory_id' => $value->id,
                    'subcategory_name' => $value->title,
                    'type' => 'subcategory',
                    'short_state'=> $value->short_code ? $value->short_code : '',
                    'suburb' => '',
                ];
            }
        }
        if ($tertiaryCategoryData->count() > 0) {
            foreach ($tertiaryCategoryData as $key => $value) {
                $resp[] = [

                    'tertiaryCategory_id' => $value->id,
                    'tertiaryCategory_name' => $value->title,
                    'type' => 'tertiarycategory',

                ];
            }
        }

        if (count($resp) > 0) {
            return response()->json(['error' => false, 'message' => 'Details found', 'data' => $resp]);
        } else {
            return response()->json(['error' => true, 'message' => 'No details found. Try again!']);
        } */
    }

    //for postcode category search

    public function Postcodecategory(Request $request)
    {
        $keyword = $request->code;

        $cat_level1 = DB::table('directory_categories')->where('title', 'like', $keyword.'%')->limit(6)->get();

        $resp = [];

        if ($cat_level1->count() > 0) {
            foreach($cat_level1 as $value) {
                $resp[] = [
                    'id' => $value->id,
                    'title' => $value->title,

                ];
            }



        }


        if (count($resp) > 0) {
            return response()->json(['error' => false, 'message' => 'Details found', 'data' => $resp]);
        } else {
            return response()->json(['error' => true, 'message' => 'No details found. Try again!']);
        }


    }

        //state wise postcode

    public function statewisePostcode($postcode="")
    {

        if ($postcode != "") {
            $zipcode = DB::select("SELECT name AS state FROM  states WHERE short_code = '$postcode'");
            //dd($zipcode);
            $state_name = $zipcode[0]->state;
            $postcode = DB::select("SELECT id, pin  FROM `pin_codes` WHERE state_code = '$postcode' ORDER BY pin ASC");
        } else {
            $state_name = 'all';
            $postcode = DB::select("SELECT p.id, p.pin AS pin FROM `pin_codes` AS p INNER JOIN states AS c ON p.state_id = c.id ORDER BY c.name ASC, p.pin ASC;");
        }

		$resp = [
            'state' => $state_name,
            'postcode' => [],
        ];

        foreach($postcode as $cat) {
            $resp['postcode'][] = [
                'postcode_id' => $cat->id,
                'postcode_title' => $cat->pin,
            ];
        }
        return response()->json(['error' => false, 'message' => 'State wise Postcode  list', 'data' => $resp]);
    }


}
