<?php

namespace App\Repositories;

use App\Models\DemoImage;
use App\Models\PinCode;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\DemoImageContract;
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
class DemoImageRepository extends BaseRepository implements DemoImageContract
{
    use UploadAble;

    /**
     * BlogCategoryRepository constructor.
     * @param DemoImage $model
     */
    public function __construct(DemoImage $model)
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
    

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findDemoImageById(int $id)
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
    public function createDemoImage(array $params)
    {
        try {

            $collection = collect($params);

            $demo = new DemoImage;

            DemoImage::where('title',$collection['title'])->delete();

            $demo->title = $collection['title'];
            if (isset($collection['image'])) {
                $profile_image = $collection['image'] ?? '';
                $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
                $profile_image->move("Demo/",$imageName);
                $uploadedImage = $imageName;
                $demo->image = $uploadedImage;
            }

            $demo->save();

            return $demo;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDemoImage(array $params)
    {
        $demo = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $demo->title = $collection['title'];
        if (isset($collection['image'])) {
            $profile_image = $collection['image'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("Demo/",$imageName);
            $uploadedImage = $imageName;
            $demo->image = $uploadedImage;
            }

        $demo->save();

        return $demo;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteDemoImage($id)
    {
        $demo = $this->findOneOrFail($id);
        $demo->delete();
        return $demo;
    }

   
}
