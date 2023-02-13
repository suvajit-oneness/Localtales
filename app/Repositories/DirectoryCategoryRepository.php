<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\BlogCategory;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\DirectoryCategoryContract;
use App\Models\DirectoryCategory;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\File;

/**
 * Class DirectoryCategoryRepository
 *
 * @package \App\Repositories
 */
class DirectoryCategoryRepository extends BaseRepository implements DirectoryCategoryContract
{
    use UploadAble;

    /**
     * DirectoryCategoryRepository constructor.
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
    public function listdirectoryCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function finddirectoryCategoryById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return DirectoryCategory|mixed
     */
    public function createdirectoryCategory(array $params)
    {
        try {

            $collection = collect($params);

            $category = new DirectoryCategory;
            $category->title = $collection['title'];

            $slug = Str::slug($collection['title'], '-');
            $slugExistCount = DirectoryCategory::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
            $category->slug = $slug;

            if ($collection['image']) {
                $category->image = $collection['image'];
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
    public function updatedirectoryCategory(array $params)
    {
        $category = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $category->title = $collection['title'];
        $slug = Str::slug($collection['title'], '-');
        $slugExistCount = DirectoryCategory::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
        $category->slug = $slug;
        // $profile_image = $collection['image'];
        // $imageName = time().".".$profile_image->getClientOriginalName();
        // $profile_image->move("categories/",$imageName);
        // $uploadedImage = $imageName;
        // $category->image = $uploadedImage;

        if ($collection['image']) {
            if ($category->image != 'placeholder-image.png')
                File::delete(public_path() . '/admin/uploads/directorycategory/images/' . $category->image);

            $category->image = $collection['image'];
        }

        $category->save();

        return $category;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deletedirectoryCategory($id)
    {
        $category = $this->findOneOrFail($id);

        if ($category->image != 'placeholder-image.png')
            File::delete(public_path() . '/admin/uploads/directorycategory/images/' . $category->image);

        $category->delete();
        return $category;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatedirectoryCatStatus(array $params)
    {
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
    public function detailsdirectoryCategory($id)
    {
        $categories = DirectoryCategory::where('id', $id)->get();

        return $categories;
    }

    /**
     * @return mixed
     */
    public function getSearchCategory(string $term)
    {
        return DirectoryCategory::where([['title', 'LIKE', '%' . $term . '%']])

            ->paginate(25);
    }
}
