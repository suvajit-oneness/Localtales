<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\Directory;
use App\Models\Collection;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\PinCode;
use App\Models\Suburb;
use Illuminate\Support\Facades\DB;

class SitemapController extends BaseController
{
    public function index(Request $request)
    {
        $directoryCount = Directory::where('status', 1)->count();
        $per_page = 10000;
        $totalDirectoryPages = (int) floor($directoryCount / $per_page);

        return response()->view('site.sitemap.index', compact('totalDirectoryPages'))->header('Content-Type', 'text/xml');
    }

    public function detail(Request $request, $slug='')
    {
        $per_page = 10000;

        // directory
        if (strpos($slug, 'directory') !== false) {
            $type = 'directory';
            $current_url = url()->current();

            // get only last 5 charc
            $url_page = substr($current_url, -5);
            // Use preg_match_all() function to check match
            preg_match_all('!\d+!', $url_page, $numbersOnly);
            $currentPage = (int) $numbersOnly[0][0];

            // max directory page limit
            $directoryCount = Directory::where('status', 1)->count();
            $totalDirectoryPages = (int) floor($directoryCount / $per_page);

            // dd($currentPage, $totalDirectoryPages);

            if ($currentPage > 0 && $currentPage <= $totalDirectoryPages) {
                $offset = ($currentPage - 1) * $per_page;

                $data = Directory::select('name', 'slug', 'created_at')
                ->where('status', 1)
                ->offset($offset)
                ->limit($per_page)
                ->get()
                ->toArray();

                // dd(DB::getQueryLog());
            } else {
                return response()->view('site.404');
            }
        }

        // collection
        elseif (strpos($slug, 'collection') !== false) {
            $type = 'collection';

            $data = Collection::select('title', 'slug', 'created_at')
            // ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
        }

        // article category
        elseif (strpos($slug, 'articlecategory') !== false) {
            $type = 'articlecategory';

            $data = BlogCategory::select('title', 'slug', 'created_at')
            // ->where('status', 1)
            ->orderBy('title')
            ->get()
            ->toArray();
        }

        // article
        elseif (strpos($slug, 'articles') !== false) {
            $type = 'article';

            $data = Blog::select('title', 'slug', 'created_at')
            ->where('status', 1)
            // ->orderBy('title')
            ->get()
            ->toArray();
        }

        // postcodes
        elseif (strpos($slug, 'postcodes') !== false) {
            $type = 'postcode';

            $data = PinCode::select('pin', 'created_at')
            // ->where('status', 1)
            // ->orderBy('title')
            ->get()
            ->toArray();
        }

        // suburbs
        elseif (strpos($slug, 'suburbs') !== false) {
            $type = 'suburb';

            $data = Suburb::select('name', 'slug', 'created_at')
            // ->where('status', 1)
            // ->orderBy('title')
            ->get()
            ->toArray();
        }

        // if no slug
        else {
            return redirect()->route('404');
        }

        return response()->view('site.sitemap.detail', compact('data', 'type'))->header('Content-Type', 'text/xml');
    }
}
