<?php
namespace App\Repositories;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\BlogCategoryContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use App\Models\CategoryFaq;
/**
 * Class CategoryRepository
 *
 * @package \App\Repositories
 */
class BlogCategoryRepository extends BaseRepository implements BlogCategoryContract
{
    use UploadAble;

    /**
     * BlogCategoryRepository constructor.
     * @param BlogCategory $model
     */
    public function __construct(BlogCategory $model)
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
    public function listCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCategoryById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Blogcategory|mixed
     */
    public function createCategory(array $params)
    {
        try {
            $collection = collect($params);
            $category = new BlogCategory;
            $category->title = $collection['title'];
            $category->description = $collection['description'];
            $category->short_content = $collection['short_content'];
            $category->medium_content = $collection['medium_content'];
            $category->long_content = $collection['long_content'];
            $slug = Str::slug($collection['title'], '-');
            $slugExistCount = BlogCategory::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
            $category->slug = $slug;
            if(!empty($params['image'])){
            $profile_image = $collection['image'];
		// $imageName = time().".".$profile_image->getClientOriginalName();
             $ext= $profile_image->getClientOriginalExtension();
            $imageName = mt_rand().'_'.time().".".$ext;
            $profile_image->move("categories/",$imageName);
            $uploadedImage = $imageName;
            $category->image = $uploadedImage;
            }
            if(!empty($params['medium_content_image'])){
                foreach (($params['medium_content_image']) as $imagefile) {
                //$profile_image = $collection['medium_content_image'];
                $imageName = time().".".$imagefile->getClientOriginalName();
                $imagefile->move("categories/",$imageName);
                $uploadedImage = $imageName;
                $category->medium_content_image = $uploadedImage;
                }
            }
            if(!empty($params['long_content_image'])){
                foreach (($params['long_content_image']) as $imagefile) {
               // $profile_image = $collection['long_content_image'];
                $imageName = time().".".$imagefile->getClientOriginalName();
                $imagefile->move("categories/",$imageName);
                $uploadedImage = $imageName;
                $category->long_content_image = $uploadedImage;
                }

            }
            $category->save();
            return $category;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCategory(array $params)
    {
        $category = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $category->title = $collection['title'];
        $category->description = $collection['description'];
        if($category->title != $collection['title']) {
        $slug = Str::slug($collection['title'], '-');
        $slugExistCount = BlogCategory::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
        $category->slug = $slug;
        }
        if(!empty($params['image'])){
        $profile_image = $collection['image'];
        //$imageName = time().".".$profile_image->getClientOriginalName();
        $ext= $profile_image->getClientOriginalExtension();
        $imageName = mt_rand().'_'.time().".".$ext;
        $profile_image->move("categories/",$imageName);
        $uploadedImage = $imageName;
        $category->image = $uploadedImage;
        }
           if(!empty($params['medium_content_image'])){
            foreach (($params['medium_content_image']) as $imagefile) {
            //$profile_image = $collection['medium_content_image'];
            $imageName = time().".".$imagefile->getClientOriginalName();
            $imagefile->move("categories/",$imageName);
            $uploadedImage = $imageName;
            $category->medium_content_image = $uploadedImage;
            }
        }
        if(!empty($params['long_content_image'])){
            foreach (($params['long_content_image']) as $imagefile) {
           // $profile_image = $collection['long_content_image'];
            $imageName = time().".".$imagefile->getClientOriginalName();
            $imagefile->move("categories/",$imageName);
            $uploadedImage = $imageName;
            $category->long_content_image = $uploadedImage;
            }

        }
        $category->save();
        return $category;


    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCategory($id)
    {
        $category = $this->findOneOrFail($id);
        $category->delete();
        return $category;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCategoryStatus(array $params){
        $category = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $category->status = $collection['check_status'];
        $category->save();

        return $category;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsCategory($id)
    {
        $categories = BlogCategory::where('id',$id)->get();

        return $categories;
    }
    public function getSearchCategories(string $term)
    {
        return BlogCategory::where([['title', 'LIKE', '%' . $term . '%']])->paginate(20);
    }
}
