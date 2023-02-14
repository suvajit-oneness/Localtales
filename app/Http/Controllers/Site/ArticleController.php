<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Contracts\BlogContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\ArticleFaq;
use App\Models\ArticleFeature;
use App\Models\ArticleWidget;
use App\Models\BlogCategory;
use App\Models\ArtcileFaqCategory;
use App\Models\SubCategory;
use App\Models\Blog;
use App\Models\SubCategoryLevel;
use Auth;
use DB;
class ArticleController extends BaseController
{
	/**
     * @var BlogContract
     */
    protected $blogRepository;
    /**
     * PageController constructor.
     * @param BlogContract $blogRepository
     */
    public function __construct(BlogContract $blogRepository){
        $this->blogRepository = $blogRepository;
    }
    //this method is use for display categories
    public function index(Request $request) {
        if (!empty($request->title)) {
            $blogs = DB::table('blogs')
            ->whereRaw("blog_category_id LIKE '%".$request->code."%' AND (title LIKE '%".$request->title."%') ")
            ->orWhereRaw("blog_sub_category_id LIKE '%".$request->code."%' AND (title LIKE '%".$request->title."%') ")
            ->orWhereRaw("blog_tertiary_category_id LIKE '%".$request->code."%' AND (title LIKE '%".$request->title."%') ")
            ->orWhereRaw("title LIKE '%".$request->code."%' AND (title LIKE '%".$request->title."%') ")
            ->orderBy('updated_at','desc')
            ->get();
        } 
        else {
            if ($request->type=='primary') {
                $blogs = DB::table('blogs')
                ->where('blog_category_id', 'like', '%'.$request->code.'%')
                ->orWhere('title', 'like', '%'.$request->code.'%')
                ->orderBy('updated_at','desc')
                ->get();
            }
            elseif ($request->type=='secondary') {
                $blogs = DB::table('blogs')
                ->where('blog_sub_category_id', 'like', '%'.$request->code.'%')
                ->orWhere('title', 'like', '%'.$request->code.'%')
                ->orderBy('updated_at','desc')
                ->get();
            }
            else {
                $blogs = DB::table('blogs')
                ->where('blog_tertiary_category_id', 'like', '%'.$request->code.'%')
                ->orWhere('title', 'like', '%'.$request->code.'%')
                ->orderBy('updated_at','desc')
                ->get();
            }

        }
        $latestblogs = Blog::orderBy('updated_at','desc')->where('status',1)->take(8)->get();
        $categories = BlogCategory::orderBy('title')->where('status',1)->get();
        $cat=$request->key_details ?? '';
        $catItem=BlogCategory::where('title', 'like', '%'.$cat.'%')->where('status',1)->get();
        $primaryCat=$catItem[0]->title ?? '';
        $subcat=$request->key_details ?? '';
        $subcatItem=SubCategory::where('title', 'like', '%'.$subcat.'%')->where('status',1)->get();
        $tercat=$request->key_details ?? '';
        $tercatcatItem=SubCategoryLevel::where('title', 'like', '%'.$tercat.'%')->get();
        $subcategories = SubCategory::orderBy('title')->where('status',1)->get();
        $tertiarycategories = SubCategoryLevel::orderBy('title')->where('status',1)->get();
    	$this->setPageTitle('Blog List', 'List of blogs');
        return view('site.blog.index', compact('blogs','latestblogs','categories','request','primaryCat','subcatItem','tercatcatItem','subcategories','tertiarycategories'));
    }

    /** this method is use for show detail of category
     * @param $request
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request,$slug)
    {
        $blogs = $this->blogRepository->detailsBlog($slug);
        $blog = $blogs[0];
        //dd($blog);
        $relatedBlogs = $this->blogRepository->getRelatedBlogs($blog->blog_category_id, $blog->slug);
        $latestblogs = Blog::where('slug', '!=', $slug)->where('status',1)->orderby('updated_at','desc')->get();
        $categories = $this->blogRepository->getBlogcategories();
        $widget =ArticleWidget::all();
        $feature = ArticleFeature::all();
        $faq=ArticleFaq::where('blog_id',$blog->id)->where('status',1)->get();
        $faqCat=ArtcileFaqCategory::orderby('title')->get();
        $tag=DB::table('blog_tags')->where('blog_id',$blog->id)->get();
        $this->setPageTitle($blog->title, 'Blog Details : '.$blog->title);
        return view('site.blog.details', compact('blog','relatedBlogs','latestblogs','categories','widget','feature','faq','faqCat','tag'));
    }

    /**
     * @param $id
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categoryWiseList($id,$slug)
    {
        $blogs = $this->blogRepository->categoryWiseBlogs($id);
        $latestBlogs = $this->blogRepository->latestBlogs();
        $categories = $this->blogRepository->getBlogcategories();
        $this->setPageTitle('Category Wise Blogs', 'Category wise list of blogs');
        return view('site.blog.category_wise', compact('blogs','latestBlogs','categories'));
    }

    /** this method is use for show tag of article
     * @param $request
     * @param $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articletag(Request $request,$tag)
    {
        $articleTag=DB::table('blog_tags')->where('slug',$tag)->get();
        $id=$tag[0]->id ?? '';
        if ( !empty($request->keyword) ) {
        $keyword = (isset($request->keyword) && $request->keyword!='')?$request->keyword:'';
        $blogs = DB::table('blogs')
                ->where('title', 'like', '%'.$keyword.'%')
                ->where('slug', 'like', '%'.$tag.'%')
                ->where('status' , 1)
                ->orderBy('title')
                ->get();
        }
        else{
            $blogs= Blog::where('slug', 'like', '%'.$tag.'%')->where('status', 1)->get();

        }
        $latestblogs = $this->blogRepository->latestBlogs();
        $categories = BlogCategory::orderBy('title')->get();
        $subcategories = SubCategory::orderBy('title')->get();
        $tertiarycategories = SubCategoryLevel::orderBy('title')->get();
        $pin=$this->PincodeRepository->listPincode();
        $suburb=$this->SuburbRepository->listSuburb();
    	$this->setPageTitle('Blog List', 'List of blogs');
        return view('site.blog.article-tag', compact('blogs','latestblogs','categories','pin','suburb','subcategories','tertiarycategories','articleTag'));
    }
}

