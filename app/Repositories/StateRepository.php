<?php

namespace App\Repositories;

use App\Models\State;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\StateContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Class StateRepository
 *
 * @package \App\Repositories
 */
class StateRepository extends BaseRepository implements StateContract
{
    use UploadAble;

    /**
     * BlogCategoryRepository constructor.
     * @param State $model
     */
    public function __construct(State $model)
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
    public function listStates(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findStateById(int $id)
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
    public function createState(array $params)
    {
        try {

            $collection = collect($params);

            $state = new State;
            $state->name = $collection['name'];
            $state->image = $collection['image'];
            $state->short_code = $collection['short_code'];

            $slug = Str::slug($collection['name'], '-');
            $slugExistCount = State::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
            $state->slug = $slug;

            $state->save();

            return $state;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateState(array $params)
    {
        $state = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        
        if($state->name != $collection['name']){
            $slug = Str::slug($collection['name'], '-');
            $slugExistCount = State::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
            $state->slug = $slug;
        }

        $state->name = $collection['name'];
        $state->short_code = $collection['short_code'];
        // $profile_image = $collection['image'];
        // $imageName = time().".".$profile_image->getClientOriginalName();
        // $profile_image->move("categories/",$imageName);
        // $uploadedImage = $imageName;
        // $category->image = $uploadedImage;

        if (isset($collection['image'])) {
            if ($state->image != 'placeholder-image.png')
                File::delete(public_path() . '/admin/uploads/state/images/' . $state->image);
            $state->image = $collection['image'];
        }

        $state->save();

        return $state;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteState($id)
    {
        $state = $this->findOneOrFail($id);

        if ($state->image != 'placeholder-image.png')
            File::delete(public_path() . '/admin/uploads/state/images/' . $state->image);

        $state->delete();
        return $state;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateStateStatus(array $params)
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
    public function detailsState($id)
    {
        $categories = State::where('id', $id)->get();

        return $categories;
    }

    /**
     * @return mixed
     */
    public function getSearchState(string $term)
    {
        return State::where([['name', 'LIKE', '%' . $term . '%']])->get();
    }
}
