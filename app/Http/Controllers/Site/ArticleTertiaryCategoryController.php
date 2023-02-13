<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategoryLevel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Models\SubCategory;
use Auth;
use Symfony\Component\Console\Input\Input;

class ArticleTertiaryCategoryController extends BaseController
{

 public function index(Request $request,$catslug,$subcatslug,$slug)
    {
       $this->setPageTitle('SubCategory', 'About Article SubCategory');
       $cat=SubCategoryLevel::where('slug',$slug)->where('status',1)->get();
       $id=$cat[0]->id;
      // $faq = DB::table('category_faqs')->where('category_id', 'like', '%'.$id.'%')->where('status',1)->get();
       $articlecat=SubCategory::where('slug',$subcatslug)->get();
       $latestBlogs = DB::table('blogs')->where('blog_tertiary_category_id', 'like', '%'.$id.'%')->where('status',1)->where('image','!=','')->orderby('updated_at','desc')->paginate(16);
      // dd($latestBlogs);
       $articletercat=SubCategoryLevel::where('status',1)->orderby('title')->get();
       return view('site.blog.tertiarycategory.index', compact('cat','latestBlogs','articlecat','articletercat'));

    }
}
