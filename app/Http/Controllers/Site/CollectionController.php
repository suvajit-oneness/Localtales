<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Collection;
use App\Models\CollectionDirectory;

use App\Contracts\DirectoryContract;

class CollectionController extends BaseController
{
    protected $DirectoryRepository;

    public function __construct(DirectoryContract $DirectoryRepository)
    {
        $this->DirectoryRepository = $DirectoryRepository;
    }

    public function index(Request $request)
    {
        $this->setPageTitle('Collection ', 'Collection page');

        if ( !empty($request->keyword) || !empty($request->name) ) {
            if (!empty($request->keyword)) {
                $keywordQuery = " AND (suburb LIKE '%$request->keyword%' OR pin_code LIKE '%$request->keyword%')";
            } else {
                $keywordQuery = "";
            }

            if (!empty($request->name)) {
                $nameQuery = " AND title LIKE '%$request->name%'";
            } else {
                $nameQuery = "";
            }

            $data = Collection::whereRaw(" status = 1 ".$keywordQuery.$nameQuery)
            ->paginate(40);
        } else {
            $data = Collection::where('status', 1)->paginate(40);
        }

        return view('site.collection.index', compact('data', 'request'));
    }

    public function detail(Request $request, $slug)
    {
        $this->setPageTitle('Collection ', 'Collection');

        $collectionData = Collection::where('slug', $slug)->first();
        $moreCollections = Collection::where('slug', '!=', $slug)->where('status', 1)->paginate(16);
        $directories = $this->DirectoryRepository->directorywisecollection($collectionData->id);
        $allCategoriesForMapView = CollectionDirectory::where('collection_id', $collectionData->id)->with('directory')->get();

        return view('site.collection.detail', compact('collectionData', 'moreCollections', 'directories', 'allCategoriesForMapView'));
    }

}
