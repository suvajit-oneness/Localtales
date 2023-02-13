<?php
namespace App\Repositories;

use App\Models\JobCategory;
use App\Traits\UploadAble;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Contracts\JobCategoryContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class JobCategoryRepository
 *
 * @package \App\Repositories
 */
class JobCategoryRepository extends BaseRepository implements JobCategoryContract
{
    use UploadAble;

    /**
     * JobCategoryRepository constructor.
     * @param JobCategory $model
     */
    public function __construct(JobCategory $model)
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
     * @return Category|mixed
     */
    public function createCategory(array $params)
    {
        try {
            $collection = collect($params);

            $category = new JobCategory;
            $category->title = $collection['title'] ?? '';
            $category->description = $collection['description']?? '';
            $category->slug = slugGenerate($collection['title'], 'job_categories');
            $category->status = 1;
            $category->save();
            // dd($category);

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
        $category->title = $collection['title']?? '';
        $category->description = $collection['description']?? '';
        if($category->title != $collection['title']) {
            $category->slug = slugGenerate($collection['title'], 'jobcategory');
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
    public function updateCatStatus(array $params){
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
        $categories = JobCategory::where('id',$id)->get();

        return $categories;
    }

    public function getSearchCategories(string $term)
    {
        return JobCategory::where([['title', 'LIKE', '%' . $term . '%']])->paginate(25);
    }
}
