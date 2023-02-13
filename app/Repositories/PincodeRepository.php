<?php

namespace App\Repositories;
use App\Models\Suburb;
use App\Models\PinCode;
use App\Models\HelpComment;
use App\Models\State;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\PincodeContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Auth;

/**
 * Class PincodeRepository
 *
 * @package \App\Repositories
 */
class PincodeRepository extends BaseRepository implements PincodeContract
{
    use UploadAble;

    /**
     * PincodeRepository constructor.
     * @param PinCode $model
     */
    public function __construct(PinCode $model)
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
    public function listPincode(string $order = 'pin', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findPincodeById(int $id)
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
    public function createPincode(array $params)
    {
        try {

            $collection = collect($params);

            $pin = new PinCode;
            $pin->pin = $collection['pin'];
            $pin->description = $collection['description'];
            $pin->meta_title = $collection['meta_title'];
            $pin->meta_description = $collection['meta_description'];
            $pin->state_id = $collection['state_id'];
           /* if (isset($collection['image'])) {
            if ($pin->image != 'placeholder-image.png')
                File::delete(public_path() . '/admin/uploads/pincode/images/' . $pin->image);
            $pin->image = $collection['image'];
            */
            if(!empty($params['image'])) {
                $profile_image = $collection['image'] ?? '';
                $imageName = time().".".$profile_image->getClientOriginalName();
                $profile_image->move("admin/uploads/pincode/images/",$imageName);
                $uploadedImage = $imageName;
                $pin->image = $uploadedImage;
            }

            $pin->save();

            return $pin;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePincode(array $params)
    {
        $pin = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $pin->pin = $collection['pin'];
        $pin->description = $collection['description'];
        $pin->meta_title = $collection['meta_title'];
        $pin->meta_description = $collection['meta_description'];
        $pin->state_id = $collection['state_id'];

       /* if (isset($collection['image'])) {
            if ($pin->image != 'placeholder-image.png')
                File::delete(public_path() . '/admin/uploads/pincode/images/' . $pin->image);
            $pin->image = $collection['image'];
        }*/
        if(!empty($params['image'])) {
            $profile_image = $collection['image'] ?? '';
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("admin/uploads/pincode/images/",$imageName);
            $uploadedImage = $imageName;
            $pin->image = $uploadedImage;
        }

        // $profile_image = $collection['image'];
        // $imageName = time().".".$profile_image->getClientOriginalName();
        // $profile_image->move("categories/",$imageName);
        // $uploadedImage = $imageName;
        // $category->image = $uploadedImage;

        $pin->save();

        return $pin;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deletePincode($id)
    {
        $pin = $this->findOneOrFail($id);

        if ($pin->image != 'placeholder-image.png')
            File::delete(public_path() . '/admin/uploads/suburb/' . $pin->image);

        $pin->delete();
        return $pin;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePincodeStatus(array $params)
    {
        $pin = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $pin->status = $collection['check_status'];
        $pin->save();

        return $pin;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsPincode($id)
    {
        $pin = PinCode::where('id', $id)->get();

        return $pin;
    }

    public function getAllState()
    {
        return State::all();
    }

    /**
     * @return mixed
     */
    public function getSearchpin(string $term)
    {
        return PinCode::where([['pin', 'LIKE', '%' . $term . '%']])->paginate(20);
    }


    public function searchPostcodeData($stateId, $keyword)
    {
        $pin = PinCode::when($stateId != '', function ($query) use ($stateId) {
            $query->where('state_name', '=', $stateId);
        })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('pin', 'like', '%' . $keyword . '%');
            })

            ->orderBy('pin')

            ->paginate(15)
            ->appends(request()->query());

        //   dd($blogs);
        return $pin;
    }
   public function searchSuburbData($postcode, $keyword,$suburbData)
     {
        $pin = Suburb::when($postcode != '', function ($query) use ($postcode) {
            $query->where('pin_code', '=', $postcode);
        })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($suburbData, function ($query) use ($suburbData) {
                $query->where('name', 'like', '%' . $suburbData . '%');
            })
            // ->orderBy('id', 'desc')

            ->paginate(5)
            ->appends(request()->query());

        //   dd($blogs);
        return $pin;
    }

     public function help(array $params)
    {
        try {

            $collection = collect($params);

            $item = new HelpComment;
            $item->user_id = Auth::guard('user')->user()->id ?? '';
            $item->type = $collection['type'];
            $item->user_name = $collection['user_name'];
            $item->user_email = $collection['user_email'];
            $item->comment = $collection['comment'] ?? '';
             $item->page = $collection['page'];
            $item->save();

            return $item;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

}
