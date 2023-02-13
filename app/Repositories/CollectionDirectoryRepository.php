<?php

namespace App\Repositories;

use App\Models\Directory;
use App\Models\Collection;
use App\Models\CollectionDirectory;
use App\Models\Suburb;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CollectionDirectoryContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Str;

/**
 * Class CollectionDirectoryRepository
 *
 * @package \App\Repositories
 */
class CollectionDirectoryRepository extends BaseRepository implements CollectionDirectoryContract
{
    use UploadAble;

    /**
     * BlogCategoryRepository constructor.
     * @param CollectionDirectory $model
     */
    public function __construct(CollectionDirectory $model)
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
    public function listCollectionDirectory(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCollectionDirectoryById(int $id)
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
    public function createCollectionDirectory(array $params)
    {
        try {

            $collection = collect($params);
            CollectionDirectory::where('collection_id', $collection['collection_id'])->delete();
            foreach ($params['directory_id'] as $value) {
                // if (count(CollectionDirectory::where('collection_id', $collection['collection_id'])->where('directory_id', $value)->get()) == 0) {
                $dir = new CollectionDirectory;
                $dir->collection_id = $collection['collection_id'];
                $dir->directory_id = $value;
                $dir->save();
                // }
            }

            return true;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCollectionDirectory(array $params)
    {
        $dir = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $dir->collection_id = $collection['collection_id'];
        $dir->directory_id = $collection['directory_id'];


        $dir->save();

        return $dir;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCollectionDirectory($id)
    {
        $state = $this->findOneOrFail($id);
        $state->delete();
        return $state;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCollectionDirectoryStatus(array $params)
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
    public function detailsCollectionDirectory($id)
    {
        $categories = CollectionDirectory::where('id', $id)->get();

        return $categories;
    }



    // csv upload

    public function getAllCollection()
    {
        return Collection::all();
    }
    public function getAllDirectory()
    {
        return Directory::all();
    }
    /**
     * @return mixed
     */
    public function getSearchCollection(string $term)
    {
        return CollectionDirectory::where([['title', 'LIKE', '%' . $term . '%']])->where([['address', 'LIKE', '%' . $term . '%']])

            ->get();
    }


    /**
     * @return mixed
     */
    public function getSearchDirectory($keyword)
    {
        $blogs = Directory::when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })


            ->get();

        //dd($blogs);
        return $blogs;
    }
}
