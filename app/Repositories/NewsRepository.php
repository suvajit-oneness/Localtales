<?php
namespace App\Repositories;

use App\Models\News;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\NewsContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\URL;
/**
 * Class NewsRepository
 *
 * @package \App\Repositories
 */
class NewsRepository extends BaseRepository implements NewsContract
{
    use UploadAble;

    /**
     * NewsRepository constructor.
     * @param News $model
     */
    public function __construct(News $model)
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
    public function listNews(string $order = 'id', string $sort = 'desc', array $columns = ['*'], int $page = 25)
    {
        return $this->all($columns, $order, $sort ,$page);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findNewsById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Property|mixed
     */
    public function createNews(array $params)
    {
        try {

            $collection = collect($params);

            $property = new News;
            $property->title = $collection['title'];
            $property->slug = slugGenerate($params['title'],'news');
            if(isset($params['suburb'])){
            $property->suburb = $collection['suburb'];
            }
            $property->postcode = $collection['postcode']?? '';
            $property->state = $collection['state']?? '';
            $property->description = $collection['description']?? '';
            if(isset($params['image'])){
            //$property->image = imageUpload($params['image'],'News');
            $profile_image = $collection['image'];
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/News/",$imageName);
            $imageUrl= URL::to('/').'/'.'uploads/News/'.$imageName;
            $uploadedImage = $imageUrl;
            $property->image = $uploadedImage;
            }
            $property->save();

            return $property;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateNews(array $params)
    {
        $property = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $property->title = $collection['title'];
        if($property->title != $params['title']){
            $property->slug = slugGenerate($params['title'],'news');
        }
        
        if(isset($params['suburb'])){
        $property->suburb = $collection['suburb'] ?? '';
        }
        $property->postcode = $collection['postcode'] ?? '';
        $property->state = $collection['state'] ?? '';
        $property->description = $collection['description'] ?? '';
        if(isset($params['image'])){
            //$property->image = imageUpload($params['image'],'News');
            $profile_image = $collection['image'];
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/News/",$imageName);
            $imageUrl= URL::to('/').'/'.'uploads/News/'.$imageName;
            $uploadedImage = $imageUrl;
            $property->image = $uploadedImage;
        }
        $property->save();

        return $property;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteNews($id)
    {
        $property = $this->findOneOrFail($id);
        $property->delete();
        return $property;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateNewsStatus(array $params){
        $property = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $property->status = $collection['check_status'];
        $property->save();

        return $property;
    }

     /**
     * @param $id
     * @return mixed
     */
    public function detailsNews($id)
    {
        $properties = News::where('id',$id)->get();
        
        return $properties;
    }

    /**
     * @param $term
     * @return mixed
     */
    public function getSearchNews($term)
    {
        return News::where([['title', 'LIKE', '%' . $term . '%']])
        ->paginate(25);
    }
}