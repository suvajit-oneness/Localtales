<?php

namespace App\Repositories;

use App\Models\Suburb;
use App\Models\PinCode;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\SuburbContract;
use App\Models\State;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

/**
 * Class StateRepository
 *
 * @package \App\Repositories
 */
class SuburbRepository extends BaseRepository implements SuburbContract
{
    use UploadAble;

    /**
     * BlogCategoryRepository constructor.
     * @param Suburb $model
     */
    public function __construct(Suburb $model)
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
    public function listSuburb(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findSuburbById(int $id)
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
    public function createSuburb(array $params)
    {
        try {

            $collection = collect($params);

            $suburb = new Suburb;
            $suburb->name = $collection['name'];
             $suburb->state = $collection['state'];
             $data=State::where('name', 'LIKE', '%' . $collection['state'] . '%')->get();
             $suburb->short_state = $data[0]->short_code;
             $suburb->region_name = $collection['region_name'];
            $suburb->pin_code = $collection['pin_code'];
            $suburb->description = $collection['description'];
            $suburb->meta_title = $collection['meta_title'];
            $suburb->meta_description = $collection['meta_description'];
            $suburb->house = $collection['house'];
            $suburb->population = $collection['population'];
            if (isset($collection['image'])) {
                if ($suburb->image != 'placeholder-image.png')
                    File::delete(public_path() . '/admin/uploads/suburb/' . $suburb->image);
                $suburb->image = $collection['image'];
            }
            $slug = Str::slug($collection['name'], '-');
            $slugExistCount = Suburb::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
            $suburb->slug = $slug;


            $suburb->save();

            return $suburb;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSuburb(array $params)
    {
        $suburb = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $suburb->name = $collection['name'];
        $suburb->state = $collection['state'];
        $data=State::where('name', 'LIKE', '%' . $collection['state'] . '%')->get();
        $suburb->short_state = $data[0]->short_code;
        $suburb->pin_code = $collection['pin_code'];
        $suburb->region_name = $collection['region_name'];
        $suburb->description = $collection['description'];
        $suburb->meta_title = $collection['meta_title'];
        $suburb->meta_description = $collection['meta_description'];
        $suburb->house = $collection['house'];
        $suburb->population = $collection['population'];

        if (isset($collection['image'])) {
            if ($suburb->image != 'placeholder-image.png')
                File::delete(public_path() . '/admin/uploads/suburb/' . $suburb->image);
            $suburb->image = $collection['image'];
        }
        if($suburb->name != $collection['name']) {
        $slug = Str::slug($collection['name'], '-');
        $slugExistCount = Suburb::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
        $suburb->slug = $slug;
        }
        // $profile_image = $collection['image'];
        // $imageName = time().".".$profile_image->getClientOriginalName();
        // $profile_image->move("categories/",$imageName);
        // $uploadedImage = $imageName;
        // $category->image = $uploadedImage;

        $suburb->save();

        return $suburb;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteSuburb($id)
    {
        $suburb = $this->findOneOrFail($id);
        if ($suburb->image != 'placeholder-image.png')
            File::delete(public_path() . '/admin/uploads/suburb/' . $suburb->image);
        $suburb->delete();
        return $suburb;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSuburbStatus(array $params)
    {
        $suburb = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $suburb->status = $collection['check_status'];
        $suburb->save();

        return $suburb;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsSuburb($id)
    {
        $categories = Suburb::where('id', $id)->get();

        return $categories;
    }



    public function getAllpincode()
    {
        return PinCode::all();
    }

    /**
     * @return mixed
     */
    public function getSearchSuburb(string $term)
    {
        return Suburb::where([['name', 'LIKE', '%' . $term . '%']])->orWhere('pin_code', 'LIKE', '%' . $term . '%')->orWhere('population', 'LIKE', '%' . $term . '%')->orWhere('state', 'LIKE', '%' . $term . '%')->orWhere('short_state', 'LIKE', '%' . $term . '%')->orWhere('region_name', 'LIKE', '%' . $term . '%')->orWhere('house', 'LIKE', '%' . $term . '%')->orWhere('suburbnumber', 'LIKE', '%' . $term . '%')->paginate(25);
    }

    public function searchSuburb($pinCode)
    {
        $blogs = Suburb::when($pinCode, function ($query) use ($pinCode) {
            $query->where('pin_code', '=', $pinCode);
        })
            ->get();

        return $blogs;
    }
}
