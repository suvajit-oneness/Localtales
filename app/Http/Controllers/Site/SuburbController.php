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
use App\Models\Job;
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
    }


    public function detail(Request $request, $slug)
    {
        $this->setPageTitle('Suburb Details 1', 'Local Tales');

        // suburb details
        $data = Suburb::where('slug', $slug)->first();

        // directories
        if (isset($request->code) || isset($request->keyword)) {
            // dd($request->all());
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
                ( category_id like '$code,%' or category_id like '%,$code,%')")->paginate(18)->appends(request()->query());

            } elseif ($type == "secondary") {

                $directories = DB::table('directories')->whereRaw("address like '%$data->name%' and name like '%$keyword%' and
                ( category_id like '$code,%' or category_id like '%,$code,%')")->paginate(18)->appends(request()->query());

            }
            // if no directory found
            if(count($directories) == 0) {
                $directories = DB::table('directories')->whereRaw("address like '%$data->name%' and
                ( category_tree like '%$category%' )")->paginate(18)->appends(request()->query());
            }
        } else {
            $directories = Directory::where('address', 'LIKE', '%'.$data->name.'%')
            ->where('address', 'LIKE', '%'.$data->short_state.'%')
            ->where('address', 'LIKE', '%'.$data->pin_code)
            ->paginate(18)
            ->appends(request()->query());
        }
        //job
        $jobs=Job::where('suburb', 'LIKE', '%'.$data->name)->where('status',1)->orderby('id','desc')->paginate(8);

        // similar places - other suburbs in same postcode
        $similarPlaces = Suburb::where('slug', '!=', $slug)->where('pin_code', '=', $data->pin_code)->orderby('name')->paginate(4);
          // reviews
          $reviews = DB::select("SELECT d.name, r.* FROM directories AS d
          INNER JOIN reviews AS r ON r.directory_id = d.id
          WHERE d.address like '%$data->name%'
          ORDER BY r.created_at DESC
          LIMIT 4");
         // dd($reviews);
        return view('site.suburb.detail', compact('data', 'directories', 'similarPlaces','jobs','reviews'));
    }

    public function latLngUpdate(Request $request)
    {
        $pin = Suburb::findOrFail($request->id);
        $pin->lat = $request->lat;
        $pin->lng = $request->lng;
        $pin->save();
    }
}
