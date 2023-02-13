<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Setting;
use App\Models\Directory;
use App\Models\PinCode;
use App\Models\Collection;

class IndexController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Splash ', 'Splash Screen');
        $data = Setting::where('key', '=', 'Splash Screen')->get();

        $directory = Directory::select('id')->count();
        $postcode = PinCode::count();
        $collection = Collection::count();
        return view('site.index', compact('data', 'directory', 'postcode', 'collection'));
    }
}
