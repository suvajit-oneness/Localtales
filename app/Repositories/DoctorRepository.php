<?php
namespace App\Repositories;

use App\Models\DoctorHospital;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\DoctorContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class DoctorRepository
 *
 * @package \App\Repositories
 */
class DoctorRepository extends BaseRepository implements DoctorContract
{
    use UploadAble;

    /**
     * DoctorRepository constructor.
     * @param DoctorHospital $model
     */
    public function __construct(DoctorHospital $model)
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
    public function listDoctor(string $order = 'id', string $sort = 'desc', array $columns = ['*'], int $page = 25)
    {
        return $this->all($columns, $order, $sort ,$page);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findDoctorById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return DoctorHospital|mixed
     */
    public function createDoctor(array $params)
    {
        try {

            $collection = collect($params);

            $property = new DoctorHospital;
            $property->title = $collection['title'];
            $property->slug = slugGenerate($params['title'],'doctor_hospitals');
            $property->street_address = $collection['street_address'] ?? '';
            if(isset($params['suburb'])){
                $property->suburb = $collection['suburb'];
            }
            $property->postcode = $collection['postcode'] ?? '';
            $property->state = $collection['state'] ?? '';
            $property->contact = $collection['contact'] ?? '';
            $property->email = $collection['email'] ?? '';
            $property->website = $collection['website'] ?? '';
            $property->type = $collection['type'] ?? '';
            $property->description = $collection['description'] ?? '';

            //$property->image = imageUpload($params['image'],'Property');
            
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
    public function updateDoctor(array $params)
    {
        $property = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $property->title = $collection['title'];
        if($property->title != $params['title']){
            $property->slug = slugGenerate($params['title'],'doctor_hospitals');
        }
        $property->street_address = $collection['street_address'] ?? '';
        if(isset($params['suburb'])){
        $property->suburb = $collection['suburb'] ?? '';
        }
        $property->postcode = $collection['postcode'] ?? '';
        $property->state = $collection['state'] ?? '';
        $property->contact = $collection['contact'] ?? '';
        $property->email = $collection['email'] ?? '';
        $property->website = $collection['website'] ?? '';
        $property->type = $collection['type'] ?? '';
        $property->description = $collection['description'] ?? '';
        // if(isset($params['image'])){
        //     $property->image = imageUpload($params['image'],'Property');
        // }
        $property->save();

        return $property;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteDoctor($id)
    {
        $property = $this->findOneOrFail($id);
        $property->delete();
        return $property;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDoctorStatus(array $params){
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
    public function detailsDoctor($id)
    {
        $properties = DoctorHospital::where('id',$id)->get();
        
        return $properties;
    }

    /**
     * @param $term
     * @return mixed
     */
    public function getSearchDoctor($term)
    {
        return DoctorHospital::where([['title', 'LIKE', '%' . $term . '%']])
        ->paginate(25);
    }
}