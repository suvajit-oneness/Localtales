<?php
namespace App\Repositories;

use App\Models\Setting;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\FaqModuleContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class ContactRepository
 *
 * @package \App\Repositories
 */
class FaqModuleRepository extends BaseRepository implements FaqModuleContract
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
    public function listfaq(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->model->where('key', 'faq')->get();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findfaqById(int $id)
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
    public function updatefaq(array $params)
    {
        $contact = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $contact->pretty_name = $collection['pretty_name'];
        $contact->content = $collection['content'];
        $image = $collection['image'];
        $imageName = time().".".$image->getClientOriginalName();
        $image->move("Contactus/",$imageName);
        $uploadedImage = $imageName;
        $contact->image = $uploadedImage;

        $banner_image = $collection['banner_image'];
        $imageName = time().".".$banner_image->getClientOriginalName();
        $banner_image->move("ContactusBanner/",$imageName);
        $uploadedImage = $imageName;
        $contact->banner_image = $uploadedImage;
        
        $contact->save();

        return $contact;
    }






    /**
     * @param $id
     * @return mixed
     */
    public function detailsfaq($id)
    {
        $contact = Setting::where('id',$id)->get();

        return $contact;
    }
}
