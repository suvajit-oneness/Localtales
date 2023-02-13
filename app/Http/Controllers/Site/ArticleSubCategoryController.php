<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Models\BlogCategory;
use Auth;
use Symfony\Component\Console\Input\Input;

class ArticleSubCategoryController extends BaseController
{

 public function index(Request $request,$catslug,$slug)
    {
       $this->setPageTitle('SubCategory', 'About Article SubCategory');
       $cat=SubCategory::where('slug',$slug)->where('status',1)->get();
       $id=$cat[0]->id;
      // $faq = DB::table('category_faqs')->where('category_id', 'like', '%'.$id.'%')->where('status',1)->get();
       $articlecat=BlogCategory::where('slug',$catslug)->get();
       $latestBlogs = DB::table('blogs')->where('blog_sub_category_id', 'like', '%'.$id.'%')->where('status',1)->where('image','!=','')->orderby('updated_at','desc')->paginate(16);
      // dd($latestBlogs);
       $articlesubcat=SubCategory::where('status',1)->orderby('title')->get();
       return view('site.blog.subcategory.index', compact('cat','latestBlogs','articlecat','articlesubcat'));

    }
}
