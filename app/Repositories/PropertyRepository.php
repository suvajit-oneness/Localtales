<?php
namespace App\Repositories;

use App\Models\Property;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\PropertyContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\URL;
/**
 * Class PropertyRepository
 *
 * @package \App\Repositories
 */
class PropertyRepository extends BaseRepository implements PropertyContract
{
    use UploadAble;

    /**
     * PropertyRepository constructor.
     * @param Property $model
     */
    public function __construct(Property $model)
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
    public function listProperties(string $order = 'id', string $sort = 'desc', array $columns = ['*'], int $page = 25)
    {
        return $this->all($columns, $order, $sort ,$page);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findPropertyById(int $id)
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
    public function createProperty(array $params)
    {
        try {

            $collection = collect($params);

            $property = new Property;
            $property->title = $collection['title'];
            $property->slug = slugGenerate($params['title'],'properties');
            $property->street_address = $collection['street_address'] ?? '';
            if(isset($params['suburb'])){
            $property->suburb = $collection['suburb'];
            }
            $property->postcode = $collection['postcode']?? '';
            $property->state = $collection['state']?? '';
            $property->bedroom = $collection['bedroom']?? '';
            $property->bathroom = $collection['bathroom']?? '';
            $property->price = $collection['price']?? '';
            $property->type = $collection['type']?? '';
            $property->description = $collection['description']?? '';
            if(isset($params['image'])){
           // $property->image = imageUpload($params['image'],'Property');
           $profile_image = $collection['image'];
           $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
           $profile_image->move("uploads/Property/",$imageName);
           $imageUrl= URL::to('/').'/'.'uploads/Property/'.$imageName;
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
    public function updateProperty(array $params)
    {
        $property = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $property->title = $collection['title'];
        if($property->title != $params['title']){
            $property->slug = slugGenerate($params['title'],'properties');
        }
        $property->street_address = $collection['street_address'] ?? '';
        if(isset($params['suburb'])){
        $property->suburb = $collection['suburb'] ?? '';
        }
        $property->postcode = $collection['postcode'] ?? '';
        $property->state = $collection['state'] ?? '';
        $property->bedroom = $collection['bedroom'] ?? '';
        $property->bathroom = $collection['bathroom'];
        $property->price = $collection['price']?? '';
        $property->type = $collection['type']?? '';
        $property->description = $collection['description']?? '';
        if(isset($params['image'])){
            //$property->image = imageUpload($params['image'],'Property');
            $profile_image = $collection['image'];
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/Property/",$imageName);
            $imageUrl= URL::to('/').'/'.'uploads/Property/'.$imageName;
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
    public function deleteProperty($id)
    {
        $property = $this->findOneOrFail($id);
        $property->delete();
        return $property;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePropertyStatus(array $params){
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
    public function detailsProperty($id)
    {
        $properties = Property::where('id',$id)->get();
        
        return $properties;
    }

    /**
     * @param $term
     * @return mixed
     */
    public function getSearchProperties($term)
    {
        return Property::where([['title', 'LIKE', '%' . $term . '%']])
        ->paginate(25);
    }
}