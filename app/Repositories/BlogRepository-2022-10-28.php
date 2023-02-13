<?php
namespace App\Repositories;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\SubCategory;
use App\Models\BlogTag;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\BlogContract;
use App\Models\ArticleFeature;
use App\Models\PinCode;
use App\Models\SubCategoryLevel;
use App\Models\Suburb;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Str;
/**
 * Class BlogRepository
 *
 * @package \App\Repositories
 */
class BlogRepository extends BaseRepository implements BlogContract
{
    use UploadAble;

    /**
     * BlogRepository constructor.
     * @param Blog $model
     */
    public function __construct(Blog $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBlogs(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findBlogById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Blog|mixed
     */
    public function createBlog(array $params)
    {
        try {
            $collection = collect($params);

            $blog = new Blog;
            $blog->title = $collection['title'];

            $blog->blog_category_id = implode(',',$collection['blog_category_id']);
            $blog->blog_sub_category_id = $collection['blog_sub_category_id'] ?? '';
            $blog->blog_tertiary_category_id = $collection['blog_tertiary_category_id'] ?? '';
            $blog->pincode = $collection['pincode'] ?? '';
            $blog->suburb_id = $collection['suburb_id'] ?? '';
            $blog->content = $collection['content'];
            $blog->meta_title = $collection['meta_title'] ?? '';
            $blog->meta_key = $collection['meta_key'] ?? '';
            $blog->meta_description = $collection['meta_description'] ?? '';
            //$blog->tag = $collection['tag'] ?? '';
            $blog->heading = $collection['heading'] ?? '';
            $blog->sticky_content = $collection['sticky_content'] ?? '';
            $blog->btn_text = $collection['btn_text'] ?? '';
            $blog->btn_link = $collection['btn_link'] ?? '';
            $blog->type = $collection['type'] ?? '';

            // slug generate
            $slug = Str::slug($collection['title'], '-');
            $slugExistCount = Blog::where('title', $collection['title'])->count();
            if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
            $blog->slug = $slug;
            /*if($blog->banner_image){
            $profile_image = $collection['banner_image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Blogs/",$imageName);
            $uploadedImage = $imageName;
            $blog->banner_image = $uploadedImage;
            }*/
            if(!empty($params['image'])){
            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Blogs/",$imageName);
            $uploadedImage = $imageName;
            $blog->image = $uploadedImage;
            }
            if(!empty($params['sticky_image'])){
            $profile_image = $collection['sticky_image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Blogs/",$imageName);
            $uploadedImage = $imageName;
            $blog->sticky_image = $uploadedImage;
            }

            /*if($blog->image2){
            $profile_image = $collection['image2'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Blogs/",$imageName);
            $uploadedImage = $imageName;
            $blog->image2 = $uploadedImage;
            }*/
            $blog->status = 0;
            $blog->save();
           foreach (explode(',',$params['tag']) as $value) {
            $blogTag=new BlogTag();
            $blogTag->blog_id = $blog->id ?? '';
            $blogTag->tag = $value ?? '';
            $slug = Str::slug($value, '-');
            $slugExistCount = BlogTag::where('tag', $collection['tag'])->count();
            if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
            $blogTag->slug = $slug;
            $blogTag->save();
            }
            return $blog;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBlog(array $params)
    {
        // dd($params);
        $blog = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $blog->title = $collection['title'];
        if(!empty($collection['blog_category_id'])) {
        $blog->blog_category_id = implode(',',$collection['blog_category_id']);
        }
        if(!empty($params['blog_sub_category_id'])) {
        $blog->blog_sub_category_id = $collection['blog_sub_category_id'] ?? '';
        }
        if(!empty($params['blog_tertiary_category_id'])) {
        $blog->blog_tertiary_category_id = $collection['blog_tertiary_category_id'] ?? '';
        }
        if(!empty($params['pincode'])) {
        $blog->pincode = $collection['pincode'] ?? '';
        }
        if(!empty($params['suburb_id'])) {
        $blog->suburb_id = $collection['suburb_id'] ?? '';
        }
        $blog->content = $collection['content'];
        $blog->meta_title = $collection['meta_title'] ?? '';
        $blog->meta_key = $collection['meta_key'] ?? '';
        $blog->meta_description = $collection['meta_description'] ?? '';
        //$blog->tag = $collection['tag'] ?? '';
        $blog->heading = $collection['heading'] ?? '';
        $blog->sticky_content = $collection['sticky_content'] ?? '';
        $blog->btn_text = $collection['btn_text'] ?? '';
        $blog->btn_link = $collection['btn_link'] ?? '';
        $blog->type = $collection['type'] ?? '';

        if($blog->title != $collection['title']) {
            $slug = Str::slug($collection['title'], '-');
            $slugExistCount = Blog::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
            $blog->slug = $slug;
        }

        /* if($blog->banner_image){
            $profile_image = $collection['banner_image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Blogs/",$imageName);
            $uploadedImage = $imageName;
            $blog->banner_image = $uploadedImage;
        } */

        if(!empty($params['image'])) {
            $profile_image = $collection['image'] ?? '';
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Blogs/",$imageName);
            $uploadedImage = $imageName;
            $blog->image = $uploadedImage;
        }

       /* if($blog->image2){
        $profile_image = $collection['image2'];
        $imageName = time().".".$profile_image->getClientOriginalName();
        $profile_image->move("Blogs/",$imageName);
        $uploadedImage = $imageName;
        $blog->image2 = $uploadedImage;
        }*/
           if(!empty($params['sticky_image'])){
            $profile_image = $collection['sticky_image'] ?? '';
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Blogs/",$imageName);
            $uploadedImage = $imageName;
            $blog->sticky_image = $uploadedImage;
            }

        $blog->save();
        if($blog->tag != $collection['tag']) {
	foreach (explode(',',$params['tag']) as $value) {
            $blogTag=new BlogTag();
            $blogTag->blog_id = $blog->id ?? '';
            $blogTag->tag = $value ?? '';
           $slug = Str::slug($value, '-');
            $slugExistCount = BlogTag::where('tag', $collection['tag'])->count();
            if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
            $blogTag->slug = $slug;
            $blogTag->save();
            }
            }
        return $blog;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteBlog($id)
    {
        $blog = $this->findOneOrFail($id);
        $blog->delete();
        return $blog;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBlogStatus(array $params){
        $blog = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $blog->status = $collection['check_status'];
        $blog->save();

        return $blog;
    }

    public function updateLatestBlogStatus(array $params){
        $blog = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $blog->blog_status = $collection['check_status'];
        $blog->save();

        return $blog;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function detailsBlog($slug){
        $blogs = Blog::where('slug', $slug)->get();
        return $blogs;
    }

    public function Articledetails($id){
        $blogs = Blog::where('id', $id)->get();
        return $blogs;
    }

    /**
     * @return mixed
     */
    public function getBlogs(){
        //$blogs = Blog::with('category')->paginate(3);
        $blogs = Blog::orderBy('created_at','desc')->take(3)->get();

        return $blogs;
    }
    /**
     * @return mixed
     */
    public function getSearchBlog(string $term)
    {
        return Blog::where([['title', 'LIKE', '%' . $term . '%']])
        ->orWhere('blog_category_id', 'LIKE', '%' . $term . '%')
        ->orWhere('meta_title', 'LIKE', '%' . $term . '%')
        ->orWhere('meta_key', 'LIKE', '%' . $term . '%')
        ->paginate(25);
    }
    /**
     * @return mixed
     */
    public function getBlogcategories(){
        $categories = Blogcategory::where('status',1)->orderBy('title')->get();
        return $categories;
    }
 /**
     * @return mixed
     */
    public function getBlogsubcategories(){
        $categories = SubCategory::where('status',1)->orderBy('title')->get();

        return $categories;
    }
    public function getBlogtertiarycategories(){
        $categories = SubCategoryLevel::where('status',1)->orderBy('title')->get();

        return $categories;
    }
    /**
     * @return mixed
     */
    public function latestBlogs(){
        $blogs = Blog::where('blog_status',1)->where('image','!=','')->orderby('id','desc')->paginate(8);
        //dd($blogs);
        return $blogs;

    }

    /**
     * @return mixed
     */
    // public function getBlogtags(){
    //     $tags = Blogtag::select('tag')
    //             ->groupBy('tag')
    //             ->orderByRaw('COUNT(*) DESC')
    //             ->limit(10)
    //             ->get();

    //     return $tags;
    // }

    /**
     * @param $categoryId
     * @param $id
     * @return mixed
     */
    public function getRelatedBlogs($categoryId,$id){
        $blogs = Blog::with('category')->where('blog_category_id',$categoryId)->where('id','!=',$id)->get();

        return $blogs;
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function categoryWiseBlogs($categoryId){
        $blogs = Blog::with('category')->where('blog_category_id',$categoryId)->get();

        return $blogs;
    }
    public function getSuburb(){
        $suburb = Suburb::orderby('name')->get();

        return $suburb;
    }
    public function getPincode(){
        $pin = PinCode::orderby('pin')->get();

        return $pin;
    }

     /**
     * @param $pinCode
     * @param $categoryId
     * @param $keyword
     * @return mixed
     */
    public function searchBlogsData($categoryId,$secondaryCategoryId,$tertiaryCategoryId,$keyword){
        $blogs = Blog::with('category')->where('status','=',1)->

        when($categoryId!='', function($query) use ($categoryId){
            $query->where('blog_category_id', '=', $categoryId);
        })
         ->when($secondaryCategoryId!='', function($query) use ($secondaryCategoryId){
            $query->where('blog_sub_category_id', '=', $secondaryCategoryId);
        })
         ->when($tertiaryCategoryId!='', function($query) use ($tertiaryCategoryId){
            $query->where('blog_tertiary_category_id', '=', $tertiaryCategoryId);
        })
        ->when($keyword, function($query) use ($keyword){
            $query->where('title', 'like', '%' . $keyword .'%');
        })
        ->where('status', 1)->get();

        return $blogs;
    }
    public function searchBlogs($pinCode){
        $blogs = Blog::
        when($pinCode, function($query) use ($pinCode){
            $query->where('pincode', '=', $pinCode);
        })
        ->get();

        return $blogs;
    }

    /**
     * @param array $params
     * @return Blog|mixed
     */
    public function createFeature(array $params)
    {
        try {
            $collection = collect($params);

            $widget = new ArticleFeature();
            $widget->heading = $collection->heading;
        $widget->content = $collection->content;
        $widget->highlights = $collection->highlights;
        $widget->features = $collection->features;
        $widget->blog_id = $collection->blog_id;
        $widget->btn_text = $collection->btn_text;
        $widget->btn_link = $collection->btn_link;


            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Blogs/",$imageName);
            $uploadedImage = $imageName;
            $widget->image2 = $uploadedImage;

            $widget->save();

            return $widget;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
/**
     * @param array $params
     * @return Blog|mixed
     */
    public function updateFeature(array $params)
    {
        try {
            $widget = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
            $widget->heading = $collection->heading;
        $widget->content = $collection->content;
        $widget->highlights = $collection->highlights;
        $widget->features = $collection->features;
        $widget->blog_id = $collection->blog_id;
        $widget->btn_text = $collection->btn_text;
        $widget->btn_link = $collection->btn_link;

            if($widget->image){
            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Blogs/",$imageName);
            $uploadedImage = $imageName;
            $widget->image2 = $uploadedImage;
            }
            $widget->save();

            return $widget;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}

