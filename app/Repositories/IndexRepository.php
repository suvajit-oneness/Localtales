<?php
namespace App\Repositories;

use App\Models\Setting;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\IndexContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class ContactRepository
 *
 * @package \App\Repositories
 */
class IndexRepository extends BaseRepository implements IndexContract
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
    public function listsplash(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->model->where('key', 'Splash Screen')->get();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findsplashById(int $id)
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
    public function updatesplash(array $params)
    {
        $contact = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $contact->pretty_name = $collection['pretty_name'];
        $contact->content = $collection['content'];
        $contact->content1 = $collection['content1'];
        $contact->content2 = $collection['content2'];
        if(!empty($params['image'])){
        $image = $collection['image'];
        $imageName = time().".".$image->getClientOriginalName();
        $image->move("Extra/",$imageName);
        $uploadedImage = $imageName;
        $contact->image = $uploadedImage;
        }
        if(!empty($params['banner_image'])){
        $banner_image = $collection['banner_image'];
        $imageName = time().".".$banner_image->getClientOriginalName();
        $banner_image->move("SplashBanner/",$imageName);
        $uploadedImage = $imageName;
        $contact->banner_image = $uploadedImage;
        }
        if(!empty($params['image2'])){
        $extra_image = $collection['image2'];
        $imageName = time().".".$extra_image->getClientOriginalName();
        $extra_image->move("Splash/",$imageName);
        $uploadedImage = $imageName;
        $contact->image2 = $uploadedImage;
        }
        if(!empty($params['logo'])){
        $logo = $collection['logo'];
        $imageName = time().".".$logo->getClientOriginalName();
        $logo->move("ContactusBanner/",$imageName);
        $uploadedImage = $imageName;
        $contact->logo = $uploadedImage;
        }
        $contact->save();

        return $contact;
    }






    /**
     * @param $id
     * @return mixed
     */
    public function detailssplash($id)
    {
        $contact = Setting::where('id',$id)->get();

        return $contact;
    }
}
