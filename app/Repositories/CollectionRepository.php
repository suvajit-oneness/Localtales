<?php

namespace App\Repositories;

use App\Models\Collection;
use App\Models\Suburb;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CollectionContract;
use App\Models\CollectionDirectory;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Str;

/**
 * Class CollectionRepository
 *
 * @package \App\Repositories
 */
class CollectionRepository extends BaseRepository implements CollectionContract
{
    use UploadAble;

    /**
     * BlogCategoryRepository constructor.
     * @param Collection $model
     */
    public function __construct(Collection $model)
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
    public function listCollection(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCollectionById(int $id)
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
    public function createCollection(array $params)
    {
        try {

            $collection = collect($params);

            $col = new Collection;
            $col->title = $collection['title'];
            $col->meta_key = $collection['meta_key'];
            $col->paragraph3 = $collection['paragraph3'];
            $col->description = $collection['description'];
            $col->pin_code = $collection['pin_code'];
            $col->paragraph1_heading = $collection['paragraph1_heading'];
            $col->suburb = $collection['suburb'];
            $col->category = $collection['category'];
            $col->paragraph1 = $collection['paragraph1'];
            $col->paragraph2_heading = $collection['paragraph2_heading'];
            $col->paragraph2 = $collection['paragraph2'];
            $col->paragraph3_heading = $collection['paragraph3_heading'];
            $col->google_doc = $collection['google_doc'];
            $col->completion = $collection['completion'];
            $col->meta_title = $collection['meta_title'];
            $col->meta_description = $collection['meta_description'];
            $slug = Str::slug($collection['title'], '-');
            $slugExistCount = Collection::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
            $col->slug = $slug;

            $profile_image = $collection['image'];
            $imageName = time() . "." . $profile_image->getClientOriginalName();
            $profile_image->move("Collection/", $imageName);
            $uploadedImage = $imageName;
            $col->image = $uploadedImage;


            $col->save();

            $c_id = $col->id;

            foreach ($collection['directory_id'] as $value) {
                $dir = new CollectionDirectory;
                $dir->collection_id = $c_id;
                $dir->directory_id = $value;
                $dir->save();
            }
            return $col;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCollection(array $params)
    {
        $col = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $col->title = $collection['title'] ?? '';
        $col->meta_key = $collection['meta_key'] ?? '';
        $col->paragraph3 = $collection['paragraph3'] ?? '';
        $col->description = $collection['description'] ?? '';
        $col->pin_code = $collection['pin_code'] ?? '';
        $col->paragraph1_heading = $collection['paragraph1_heading'] ?? '';
        $col->suburb = $collection['suburb'] ?? '';
        $col->category = $collection['category'] ?? '';
        $col->paragraph1 = $collection['paragraph1']?? '';
        $col->paragraph2_heading = $collection['paragraph2_heading'] ?? '';
        $col->paragraph2 = $collection['paragraph2'] ?? '';
        $col->paragraph3_heading = $collection['paragraph3_heading'] ?? '';
        $col->google_doc = $collection['google_doc'] ?? '';
        $col->completion = $collection['completion'] ?? '';
        $col->meta_title = $collection['meta_title'];
        $col->meta_description = $collection['meta_description'];
        if($col->title != $collection['title']) {
        $slug = Str::slug($collection['title'], '-');
        $slugExistCount = Collection::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
        $col->slug = $slug ?? '';
        }
         if (isset($collection['image'])) {
        $profile_image = $collection['image'];
        $imageName = time() . "." . $profile_image->getClientOriginalName();
        $profile_image->move("Collection/", $imageName);
        $uploadedImage = $imageName;
        $col->image = $uploadedImage ?? '';
        }

        $col->save();

        return $col;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCollection($id)
    {
        $state = $this->findOneOrFail($id);
        $state->delete();
        return $state;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCollectionStatus(array $params)
    {
        $state = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $state->status = $collection['check_status'];
        $state->save();

        return $state;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsCollection($id)
    {
        $categories = Collection::where('id', $id)->get();

        return $categories;
    }



    // csv upload

    public function getAllSuburb()
    {
        return Suburb::orderBy('name')->get();
    }

    /**
     * @return mixed
     */
    public function getSearchCollection(string $term)
    {
        return Collection::where([['title', 'LIKE', '%' . $term . '%']])
            ->orWhere('address', 'LIKE', '%' . $term . '%')
            ->orWhere('pin_code', 'LIKE', '%' . $term . '%')
            ->paginate(10);
    }

    /**
     * @param $pinCode
     * @param $keyword
     * @return mixed
     */


    public function searchCollectionData($pinCode, $keyword, $suburb, $category)
    {

        $col = Collection::when($pinCode, function ($query) use ($pinCode) {
            $query->where('pin_code', 'LIKE', '%' . $pinCode . '%');
        })

            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'LIKE', '%' . $keyword . '%');
            })
            ->when($suburb, function ($query) use ($suburb) {
                $query->where('suburb', 'LIKE', '%' . $suburb . '%');
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category', 'LIKE', '%' . $category . '%');
            })
            ->where('status', 1)->paginate(40);
        return $col;
    }
}
