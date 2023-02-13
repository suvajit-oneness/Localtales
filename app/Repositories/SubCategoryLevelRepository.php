<?php
namespace App\Repositories;

use App\Models\SubCategory;
use App\Models\SubCategoryLevel;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\SubCategoryLevelContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Str;
/**
 * Class SubCategoryLevelRepository
 *
 * @package \App\Repositories
 */
class SubCategoryLevelRepository extends BaseRepository implements SubCategoryLevelContract
{
    use UploadAble;

    /**
     * BlogCategoryRepository constructor.
     * @param SubCategoryLevel $model
     */
    public function __construct(SubCategoryLevel $model)
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
    public function listSubCategoryLevel(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findSubCategoryLevelById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return State|mixed
     */
    public function createSubCategoryLevel(array $params)
    {
        try {

            $collection = collect($params);

            $subcat = new SubCategoryLevel;
            $subcat->title = $collection['title'];
            $subcat->sub_category_id = $collection['sub_category_id'];
            $subcat->description = $collection['description'];
            $slug = Str::slug($collection['title'], '-');
            $slugExistCount = SubCategoryLevel::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
            $subcat->slug = $slug;
            if(!empty($params['image'])){
                $profile_image = $collection['image'];
                $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
                $profile_image->move("tertiarycategories/",$imageName);
                $uploadedImage = $imageName;
                $subcat->image = $uploadedImage;
                }
            $subcat->save();
            return $subcat;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSubCategoryLevel(array $params)
    {
        $subcat = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $subcat->title = $collection['title'];
        $subcat->sub_category_id = $collection['sub_category_id'];
        $subcat->description = $collection['description'];
        if($subcat->title != $collection['title']) {
        $slug = Str::slug($collection['title'], '-');
        $slugExistCount = SubCategoryLevel::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
        $subcat->slug = $slug;
        }
        if(!empty($params['image'])){
            $profile_image = $collection['image'];
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("tertiarycategories/",$imageName);
            $uploadedImage = $imageName;
            $subcat->image = $uploadedImage;
            }
        $subcat->save();

        return $subcat;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteSubCategoryLevel($id)
    {
        $subcat = $this->findOneOrFail($id);
        $subcat->delete();
        return $subcat;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSubCategoryLevelStatus(array $params){
        $subcat = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $subcat->status = $collection['check_status'];
        $subcat->save();

        return $subcat;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsSubCategoryLevel($id)
    {
        $categories = SubCategoryLevel::where('id',$id)->get();

        return $categories;
    }

public function getSubCategory(){
    return SubCategory::orderby('title')->get();
}

        // csv upload
    /**
     * @return mixed
     */
    public function getSearchSubcategorylevel(string $term)
    {
        return SubCategoryLevel::where([['title', 'LIKE', '%' . $term . '%']])

        ->paginate(25);
    }
    }



