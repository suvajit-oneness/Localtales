<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Contracts\BlogContract;
use App\Contracts\PincodeContract;
use App\Contracts\SearchContract;
use App\Contracts\SuburbContract;
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
     * @var SearchContract
     */
    protected $SearchRepository;
    /**
     * @var PincodeContract
     */
    protected $PincodeRepository;
    /**
     * @var SuburbContract
     */
    protected $SuburbRepository;


    /**
     * PageController constructor.
     * @param BlogContract $blogRepository
     * @param SearchContract $SearchRepository
     */
    public function __construct(BlogContract $blogRepository, SearchContract $SearchRepository,PincodeContract $PincodeRepository ,SuburbContract $SuburbRepository ){
        $this->blogRepository = $blogRepository;
        $this->SearchRepository = $SearchRepository;
        $this->PincodeRepository = $PincodeRepository;
        $this->SuburbRepository = $SuburbRepository;
    }

    public function index(Request $request) {
            //dd($blogs);
             if (!empty($request->title)) {
                $blogs = DB::table('blogs')
                ->whereRaw("blog_category_id LIKE '%".$request->code."%' AND (title LIKE '%".$request->title."%') ")
                ->orWhereRaw("blog_sub_category_id LIKE '%".$request->code."%' AND (title LIKE '%".$request->title."%') ")
                ->orWhereRaw("blog_tertiary_category_id LIKE '%".$request->code."%' AND (title LIKE '%".$request->title."%') ")
                ->orWhereRaw("title LIKE '%".$request->code."%' AND (title LIKE '%".$request->title."%') ")
                ->orderBy('updated_at','desc')
                ->get();
             } else {
                if ($request->type=='primary') {
                    $blogs = DB::table('blogs')
                    ->where('blog_category_id', 'like', '%'.$request->code.'%')
                    ->orWhere('title', 'like', '%'.$request->code.'%')
                    ->orderBy('updated_at','desc')
                    ->get();
                }elseif ($request->type=='secondary') {
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

           /* if (!empty($request->title)) {
                $blogs = DB::table('blogs')
                ->whereRaw("blog_category_id LIKE '%".$request->keyword."%' AND (title LIKE '%".$request->title."%') ")
                ->orWhereRaw("blog_sub_category_id LIKE '%".$request->keyword."%' AND (title LIKE '%".$request->title."%') ")
                ->orWhereRaw("blog_tertiary_category_id LIKE '%".$request->keyword."%' AND (title LIKE '%".$request->title."%') ")
                ->orWhereRaw("title LIKE '%".$request->keyword."%' AND (title LIKE '%".$request->title."%') ")
                ->orderBy('title')
                ->get();

             else{
                if($request->type=='cat_level1'){

                $blogs = DB::table('blogs')
                ->where('blog_category_id', 'like', '%'.$request->keyword.'%')
                ->orWhere('title', 'like', '%'.$request->keyword.'%')
                ->orderBy('title')
                ->get();
                }
                elseif($request->type=='cat_level2')
                {
                    $blogs = DB::table('blogs')
                ->where('blog_sub_category_id', 'like', '%'.$request->keyword.'%')
                ->orWhere('title', 'like', '%'.$request->keyword.'%')
                ->orderBy('title')
                ->get();
                }
                else{
                    $blogs = DB::table('blogs')
                    ->where('blog_tertiary_category_id', 'like', '%'.$request->keyword.'%')
                    ->orWhere('title', 'like', '%'.$request->keyword.'%')
                    ->orderBy('title')
                    ->get();
                }
            }*/
        //$latestblogs = $this->blogRepository->latestBlogs();
        $latestblogs = Blog::orderBy('updated_at','desc')->where('status',1)->take(8)->get();
        $pin=$this->PincodeRepository->listPincode();
        $suburb=$this->SuburbRepository->listSuburb();
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
        return view('site.blog.index', compact('blogs','latestblogs','categories','pin','request','primaryCat','subcatItem','tercatcatItem','subcategories','tertiarycategories'));
    }

    /**
     * @param $id
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($slug)
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
    public function categoryWiseList($id,$slug){
        $blogs = $this->blogRepository->categoryWiseBlogs($id);
        $latestBlogs = $this->blogRepository->latestBlogs();
        $categories = $this->blogRepository->getBlogcategories();
        $this->setPageTitle('Category Wise Blogs', 'Category wise list of blogs');
        return view('site.blog.category_wise', compact('blogs','latestBlogs','categories'));
    }


    public function articletag(Request $request,$tag){

        //dd($tag);
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
            //dd($blogs);

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

