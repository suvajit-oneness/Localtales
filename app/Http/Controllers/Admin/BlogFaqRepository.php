<?php
namespace App\Repositories;

use App\Models\ArticleFaq;
use App\Models\ArtcileFaqCategory;
use App\Models\ArtcileFaqSubCategory;
use App\Models\Blogtag;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\BlogFaqContract;
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
class BlogFaqRepository extends BaseRepository implements BlogFaqContract
{
    use UploadAble;

    /**
     * BlogRepository constructor.
     * @param ArticleFaq $model
     */
    public function __construct(ArticleFaq $model)
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

            $blog = new ArticleFaq;
            $blog->blog_id = $collection['blog_id'];
            $blog->question = $collection['question'] ?? '';
            $blog->answer = $collection['answer'];

            // slug generate
            $blog->save();

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
        $blog = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $blog->blog_id = $collection['blog_id'];
        $blog->question = $collection['question'] ?? '';
        $blog->answer = $collection['answer'];

        $blog->save();

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

    /**
     * @param $id
     * @return mixed
     */
    public function detailsBlog($id){
        $blogs = ArticleFaq::with('category')->where('id',$id)->get();

        return $blogs;
    }

    /**
     * @return mixed
     */
    public function getBlogs(){
        //$blogs = Blog::with('category')->paginate(3);
        $blogs = ArticleFaq::orderBy('created_at','desc')->take(3)->get();

        return $blogs;
    }
    /**
     * @return mixed
     */
    public function getSearchBlog(string $term)
    {
        return ArticleFaq::where([['question', 'LIKE', '%' . $term . '%']])
        ->orWhere('category_id', 'LIKE', '%' . $term . '%')
        ->paginate(25);
    }
    /**
     * @return mixed
     */
    public function getBlogcategories(){
        $categories = ArtcileFaqCategory::orderBy('title')->get();
        return $categories;
    }
 /**
     * @return mixed
     */
    public function getBlogsubcategories(){
        $categories = ArtcileFaqSubCategory::orderBy('title')->get();

        return $categories;
    }
    public function getBlogtertiarycategories(){
        $categories = SubCategoryLevel::orderBy('title')->get();

        return $categories;
    }
    /**
     * @return mixed
     */
    public function latestBlogs(){
        $blogs = ArticleFaq::paginate(6);
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
        $blogs = ArticleFaq::with('category')->where('blog_category_id',$categoryId)->get();

        return $blogs;
    }
    public function getSuburb(){
        $suburb = Suburb::orderby('name')->get();

        return $suburb;
    }
    public function getPincode(){
        $pin = PinCode::get();

        return $pin;
    }

     /**
     * @param $pinCode
     * @param $categoryId
     * @param $keyword
     * @return mixed
     */
    public function searchBlogsData($categoryId,$secondaryCategoryId,$tertiaryCategoryId,$keyword){
        $blogs = ArticleFaq::with('category')->where('status','=',1)->

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
        ->get();

        return $blogs;
    }
    public function searchBlogs($pinCode){
        $blogs = ArticleFaq::
        when($pinCode, function($query) use ($pinCode){
            $query->where('pincode', '=', $pinCode);
        })
        ->get();

        return $blogs;
    }
}
