<?php
namespace App\Repositories;

use App\Models\Setting;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\FrontCollectionContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class FrontCollectionRepository
 *
 * @package \App\Repositories
 */
class FrontCollectionRepository extends BaseRepository implements FrontCollectionContract
{
    use UploadAble;

    /**
     * ContactRepository constructor.
     * @param Setting $model
     */
    public function __construct(Setting $model)
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
    public function listsfrontcollection(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->model->where('key', 'Collection')->get();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findfrontcollectionById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }


    /**
     * @param array $params
     * @return mixed
     */
    public function updatefrontcollection(array $params)
    {
        $contact = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $contact->pretty_name = $collection['pretty_name'];
        $contact->content = $collection['content'];
        $contact->content1 = $collection['content1'];
        $contact->content2 = $collection['content2'];
        // $image = $collection['image'];
        // $imageName = time().".".$image->getClientOriginalName();
        // $image->move("Extra/",$imageName);
        // $uploadedImage = $imageName;
        // $contact->image = $uploadedImage;

        $banner_image = $collection['banner_image'];
        $imageName = time().".".$banner_image->getClientOriginalName();
        $banner_image->move("SplashBanner/",$imageName);
        $uploadedImage = $imageName;
        $contact->banner_image = $uploadedImage;

        // $extra_image = $collection['image2'];
        // $imageName = time().".".$extra_image->getClientOriginalName();
        // $extra_image->move("Splash/",$imageName);
        // $uploadedImage = $imageName;
        // $contact->image2 = $uploadedImage;


        // $logo = $collection['logo'];
        // $imageName = time().".".$logo->getClientOriginalName();
        // $logo->move("ContactusBanner/",$imageName);
        // $uploadedImage = $imageName;
        // $contact->logo = $uploadedImage;
        $contact->save();

        return $contact;
    }






    /**
     * @param $id
     * @return mixed
     */
    public function detailsfrontcollection($id)
    {
        $contact = Setting::where('id',$id)->get();

        return $contact;
    }
}
