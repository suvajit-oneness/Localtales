<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Auth;
use Symfony\Component\Console\Input\Input;

class ArticleCategoryController extends BaseController
{

 public function index(Request $request,$slug)
    {
       $this->setPageTitle('Category', 'About Article Category');
       $cat=BlogCategory::where('slug',$slug)->where('status',1)->get();
       $id=$cat[0]->id;
       $faq = DB::table('category_faqs')->where('category_id', 'like', '%'.$id.'%')->where('status',1)->get();
       $latestBlogs = DB::table('blogs')->where('blog_category_id', 'like', '%'.$id.'%')->where('status',1)->where('image','!=','')->orderby('updated_at','desc')->paginate(16);
      // dd($latestBlogs);
       $articlecat=BlogCategory::where('status',1)->get();
       return view('site.blog.category.index', compact('cat','latestBlogs', 'faq','articlecat'));

    }
}
