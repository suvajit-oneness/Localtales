<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\AboutContract;
use App\Contracts\ContactContract;
use App\Contracts\EventContract;
use App\Contracts\DealContract;
use App\Contracts\DirectoryContract;
use App\Contracts\DirectoryCategoryContract;
use App\Contracts\FaqContract;
use App\Contracts\BlogContract;
use App\Contracts\FaqModuleContract;
use App\Contracts\SuburbContract;
use App\Contracts\PincodeContract;
use App\Models\Directory;
use App\Models\Setting;
use App\Models\State;
use App\Models\Blog;
use App\Models\PinCode;
use App\Models\Suburb;
use App\Models\DirectoryCategory;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Auth;
use Symfony\Component\Console\Input\Input;

class SuburbController extends BaseController
{
    protected $AboutRepository;
    /**
     * ContentController constructor.
     */
    public function __construct(
        AboutContract $AboutRepository,
        ContactContract $ContactRepository,
        FaqModuleContract $FaqModuleRepository,
        FaqContract $FaqRepository,
        DealContract $dealRepository,
        EventContract $eventRepository,
        DirectoryContract $DirectoryRepository,
        BlogContract $blogRepository,
        SuburbContract $SuburbRepository,
        DirectoryCategoryContract $DirectoryCategoryRepository,
        PincodeContract $PincodeRepository
    ) {
        $this->AboutRepository = $AboutRepository;
        $this->ContactRepository = $ContactRepository;
        $this->FaqRepository = $FaqRepository;
        $this->FaqModuleRepository = $FaqModuleRepository;
        $this->dealRepository = $dealRepository;
        $this->eventRepository = $eventRepository;
        $this->DirectoryRepository = $DirectoryRepository;
        $this->blogRepository = $blogRepository;
        $this->SuburbRepository = $SuburbRepository;
        $this->DirectoryCategoryRepository = $DirectoryCategoryRepository;
        $this->PincodeRepository = $PincodeRepository;
    }

    public function index(Request $request)
    {
        $this->setPageTitle('Suburb', 'Local Tales');

        if ( !empty($request->keyword) || !empty($request->name) ) {
            if (!empty($request->name)) {
                $suburb = DB::table('suburbs')
                ->whereRaw("pin_code LIKE '%".$request->keyword."%' AND (name LIKE '%".$request->name."%' OR state LIKE '%".$request->name."%' OR short_state LIKE '%".$request->name."%') ")
                ->orWhereRaw("state LIKE '%".$request->keyword."%' AND (name LIKE '%".$request->name."%' OR state LIKE '%".$request->name."%' OR short_state LIKE '%".$request->name."%') ")
                ->orWhereRaw("short_state LIKE '%".$request->keyword."%' AND (name LIKE '%".$request->name."%' OR state LIKE '%".$request->name."%' OR short_state LIKE '%".$request->name."%') ")
                ->orWhereRaw("name LIKE '%".$request->keyword."%' AND (name LIKE '%".$request->name."%' OR state LIKE '%".$request->name."%' OR short_state LIKE '%".$request->name."%') ")
                ->orderBy('name')
                ->paginate(18);
            } else {
                $suburb = DB::table('suburbs')
                ->where('pin_code', 'like', '%'.$request->keyword.'%')
                ->orWhere('state', 'like', '%'.$request->keyword.'%')
                ->orWhere('short_state', 'like', '%'.$request->keyword.'%')
                ->orWhere('name', 'like', '%'.$request->keyword.'%')
                ->orderBy('name')
                ->paginate(18);
            }
        } else {
            $suburb = DB::table('suburbs')->where('status', 1)->orderBy('name')->paginate(18);
        }

        $state = State::orderBy('name')->get();
        return view('site.suburb.index', compact('suburb', 'state'));

        /*
        $this->setPageTitle('Suburb', 'Local Tales');

        if (!empty($request->postcode) || !empty($request->name)) {
            $postcode = (isset($request->postcode) && $request->postcode != '') ? $request->postcode : '';
            $keyword = (isset($request->name) && $request->name != '') ? $request->name : '';
            $suburbData = (isset($request->suburb) && $request->suburb != '') ? $request->suburb : '';
            $suburb = $this->PincodeRepository->searchSuburbData($postcode, $keyword,$suburbData);
        }

        if (!empty($request->key_details) || !empty($request->name)) {
            if (empty($request->name)) {
                 $suburb = DB::table('suburbs')->where('pin_code', 'like', '%'.$request->keyword.'%')->orWhere('state', 'like', '%'.$request->keyword.'%')->orWhere('short_state', 'like', '%'.$request->keyword.'%')->orWhere('name', 'like', '%'.$request->keyword.'%')->orderBy('name')->paginate(15);
             }
            else {
                $suburb = DB::table('suburbs')->where('pin_code', 'like', '%'.$request->keyword.'%')->orWhere('state', 'like', '%'.$request->keyword.'%')->orWhere('short_state', 'like', '%'.$request->keyword.'%')->orWhere('name', 'like', '%'.$request->name.'%')->orderBy('name')->paginate(15);
            }

           }
             else {
                 $suburb = DB::table('suburbs')->where('status', 1)->orderBy('name')->paginate(15);
             }

             $state = State::orderBy('name')->get();
             return view('site.suburb.index', compact('suburb', 'state'));
        */
    }



    public function details(Request $request, $slug)
    {
        $this->setPageTitle('Suburb Details 1', 'Local Tales');

        // suburb details
        $data = Suburb::where('slug', $slug)->first();

        // directories
        if (isset($request->code) || isset($request->keyword)) {
            $category = $request->directory_category;
            $code = $request->code;
            $keyword = $request->keyword;
            $type = $request->type;
            $address=$request->address;

             if (!empty($keyword)) {
                $directories = DB::table('directories')->whereRaw("name like '%$keyword%'")->paginate(18)->appends(request()->query());
            } else {
                $directories = "";
            }
            // if primary category
            if ($type == "primary") {

                $directories = DB::table('directories')->whereRaw("address like '%$data->name%' and name like '%$keyword%' and
                ( category_id like '$request->code,%' or category_id like '%,$request->code,%')")->paginate(18)->appends(request()->query());

            } elseif ($type == "secondary") {
                $directories = DB::table('directories')->whereRaw("address like '%$data->name%' and name like '%$keyword%' and
                ( category_id like '$request->code,%' or category_id like '%,$request->code,%')")->paginate(18)->appends(request()->query());
            }
             // if no directory found
             if(count($directories) == 0) {
                $directories = DB::table('directories')->whereRaw("address like '%$data->name%' and
                ( category_tree like '%$category%' )")->paginate(18)->appends(request()->query());
            }
            /*$directories = Directory::where('address', 'LIKE', '%'.$data->name.'%')
            ->where('address', 'LIKE', '%'.$data->short_state.'%')
            ->where('address', 'LIKE', '%'.$data->pin_code)
            ->when(!empty($request->code), function ($query) use ($request) {
                $query->whereRaw("(category_id LIKE '$request->code,%' OR category_id LIKE '%,$request->code,%')");
            })
            ->when(!empty($request->keyword), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->keyword.'%');
            })
            ->paginate(18)
            ->appends(request()->query());*/
        } else {
            $directories = Directory::where('address', 'LIKE', '%'.$data->name.'%')
            ->where('address', 'LIKE', '%'.$data->short_state.'%')
            ->where('address', 'LIKE', '%'.$data->pin_code)
            ->paginate(18)
            ->appends(request()->query());
        }

        // similar places - other suburbs in same postcode
        $similarPlaces = Suburb::where('slug', '!=', $slug)->where('pin_code', '=', $data->pin_code)->orderby('name')->paginate(4);

        return view('site.suburb.details', compact('data', 'directories', 'similarPlaces'));




        /*
        $this->setPageTitle('Suburb Details', 'Local Tales');
        $data=Suburb::where('slug',$slug)->get();
        $item=$data[0]->name;
        $state=$data[0]->short_state;
        $pin=$data[0]->pin_code;
        $cat = $this->DirectoryRepository->getDirectorycategories();
        $categoryId = (isset($request->category_id) && $request->category_id != '') ? $request->category_id : '';
        if (isset($request->code) || isset($request->keyword) || isset($request->address)) {
            $categoryId = (isset($request->code) && $request->code != '') ? $request->code : '';
            $keyword = (isset($request->keyword) && $request->keyword != '') ? $request->keyword : '';
            $suburb = (isset($request->address) && $request->address != '') ? $request->address : '';
            $businesses_datas = $this->DirectoryRepository->searchDirectoryDatabyPostcode($categoryId, $keyword,$suburb);
        } else {
            $businesses_datas = Directory::where('address', 'LIKE', '%' . $item . '%')->where('address', 'LIKE', '%' . $state . '%')->where('address', 'LIKE', '%' . $pin . '%')
           ->paginate(9)->appends(request()->query());
        }
        $relatedProducts = Suburb::where('slug', '!=', $slug)->where('pin_code', '=', $pin)->orderby('name')->paginate(4);
        $var = DirectoryCategory::where('id',$categoryId)->get();
        $dirCat=$var[0]->title ?? '';
        $params = $request->except('_token');
        return view('site.suburb.details', compact('cat',  'businesses_datas','data','dirCat','relatedProducts'));
        */
    }
}
