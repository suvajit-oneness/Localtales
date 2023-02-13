<?php
namespace App\Repositories;

use App\Models\Property;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\PropertyContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

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
    public function listProperties(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
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
            $property->address = $collection['address'];
            $property->lat = $collection['lat'];
            $property->lon = $collection['lon'];
            $property->overview = $collection['overview'];
            $property->amenities = $collection['amenities'];
            $property->near_by = $collection['near_by'];
            $property->business_id = $collection['business_id'];
            $property->contact_person = $collection['contact_person'];
            $property->contact_email = $collection['contact_email'];
            $property->contact_phone = $collection['contact_phone'];

            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("properties/",$imageName);
            $uploadedImage = $imageName;
            $property->image = $uploadedImage;
            
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
        $property->address = $collection['address'];
        $property->lat = $collection['lat'];
        $property->lon = $collection['lon'];
        $property->overview = $collection['overview'];
        $property->amenities = $collection['amenities'];
        $property->near_by = $collection['near_by'];
        $property->business_id = $collection['business_id'];
        $property->contact_person = $collection['contact_person'];
        $property->contact_email = $collection['contact_email'];
        $property->contact_phone = $collection['contact_phone'];

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
        $properties = Property::with('business')->where('id',$id)->get();
        
        return $properties;
    }
}