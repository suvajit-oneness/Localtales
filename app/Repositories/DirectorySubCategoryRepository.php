<?php
namespace App\Repositories;

use App\Contracts\SubCategoryContract;
use Illuminate\Support\Str;
use App\Models\DirectoryCategory;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\DirectorySubCategoryContract;
use App\Models\SubCategory;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class DirectorySubCategoryRepository
 *
 * @package \App\Repositories
 */
class DirectorySubCategoryRepository extends BaseRepository implements DirectorySubCategoryContract
{
    use UploadAble;

    /**
     * SubCategoryRepository constructor.
     * @param DirectoryCategory $model
     */
    public function __construct(DirectoryCategory $model)
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
    public function listSubCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findSubCategoryById(int $id)
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
    public function createSubCategory(array $params)
    {
        try {

            $collection = collect($params);

            $category = new DirectoryCategory;
            $category->child_category = $collection['child_category'];
            $category->parent_category = $collection['parent_category'];
            if(!empty($params['child_description'])){
            $category->child_description = $collection['child_description'] ?? '';
            }
            if(!empty($params['child_short_content'])){
            $category->child_short_content = $collection['child_short_content'] ?? '';
            }
            if(!empty($params['child_medium_content'])){
            $category->child_medium_content = $collection['child_medium_content']?? '';
            }
            if(!empty($params['child_long_content'])){
            $category->child_long_content = $collection['child_long_content'] ?? '';
            }
            $category->type = 0;
            $slug = Str::slug($collection['child_category'], '-');
            $slugExistCount = DirectoryCategory::where('child_category_slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
            $category->child_category_slug = $slug;
            if(!empty($params['child_category_image'])){
                $profile_image = $collection['child_category_image'];
            // $imageName = time().".".$profile_image->getClientOriginalName();
                 $ext= $profile_image->getClientOriginalExtension();
                $imageName = mt_rand().'_'.time().".".$ext;
                $profile_image->move("admin/uploads/directorysubcategory/images/",$imageName);
                $uploadedImage = $imageName;
                $category->child_category_image = $uploadedImage;
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
    public function updateSubCategory(array $params)
    {
        $category = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $category->child_category = $collection['child_category'];
        $category->parent_category = $collection['parent_category'];
        $category->child_description = !empty($collection->child_description) ? $collection->child_description : '';
        $category->child_short_content = !empty($collection->child_short_content) ? $collection->child_short_content : '';
        $category->child_medium_content = !empty($collection->child_medium_content) ? $collection->child_medium_content : '';
        $category->child_long_content = !empty($collection->child_long_content) ? $collection->child_long_content : '';
        $category->type = 0;


        if(!empty($params['child_category_image'])){
            $profile_image = $collection['child_category_image'];
             $ext= $profile_image->getClientOriginalExtension();
            $imageName = mt_rand().'_'.time().".".$ext;
            $profile_image->move("admin/uploads/directorysubcategory/images/",$imageName);
            $uploadedImage = $imageName;
            $category->child_category_image = $uploadedImage;
            }

        $category->save();
            //dd($category);
        return $category;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteSubCategory($id)
    {
        $category = $this->findOneOrFail($id);
        $category->delete();
        return $category;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatesubCategoryStatus(array $params){
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
    public function detailsSubCategory($id)
    {
        $categories = DirectoryCategory::where('id',$id)->where('child_category','!=','NULL')->get();

        return $categories;
    }

    public function listCategory(){
        return DirectoryCategory::all();
    }

     /**
     * @return mixed
     */
    public function getSearchSubcategory(string $term)
    {
        return DirectoryCategory::where([['child_category', 'LIKE', '%' . $term . '%']])

        ->paginate(35);
    }
}
