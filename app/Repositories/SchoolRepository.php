<?php
namespace App\Repositories;

use App\Models\School;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\SchoolContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\URL;
/**
 * Class SchoolRepository
 *
 * @package \App\Repositories
 */
class SchoolRepository extends BaseRepository implements SchoolContract
{
    use UploadAble;

    /**
     * SchoolRepository constructor.
     * @param School $model
     */
    public function __construct(School $model)
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
    public function listSchool(string $order = 'id', string $sort = 'desc', array $columns = ['*'], int $page = 25)
    {
        return $this->all($columns, $order, $sort ,$page);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findSchoolById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return School|mixed
     */
    public function createSchool(array $params)
    {
        try {

            $collection = collect($params);

            $property = new School;
            $property->title = $collection['title'];
            $property->slug = slugGenerate($params['title'],'properties');
            $property->street_address = $collection['street_address']?? '';
            if(isset($params['suburb'])){
            $property->suburb = $collection['suburb'];
            }
            $property->postcode = $collection['postcode']?? '';
            $property->state = $collection['state']?? '';
            $property->contact = $collection['contact']?? '';
            $property->grade = $collection['grade']?? '';
            $property->type = $collection['type']?? '';
            $property->description = $collection['description']?? '';

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
    public function updateSchool(array $params)
    {
        $property = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $property->title = $collection['title'];
        if($property->title != $params['title']){
            $property->slug = slugGenerate($params['title'],'schools');
        }
        $property->street_address = $collection['street_address'] ?? '';
        if(isset($params['suburb'])){
        $property->suburb = $collection['suburb'] ?? '';
        }
        $property->postcode = $collection['postcode'] ?? '';
        $property->state = $collection['state'] ?? '';
        $property->contact = $collection['contact'] ?? '';
        $property->grade = $collection['grade']?? '';
        $property->type = $collection['type']?? '';
        $property->description = $collection['description']?? '';
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
    public function deleteSchool($id)
    {
        $property = $this->findOneOrFail($id);
        $property->delete();
        return $property;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSchoolStatus(array $params){
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
    public function detailsSchool($id)
    {
        $properties = School::where('id',$id)->get();
        
        return $properties;
    }

    /**
     * @param $term
     * @return mixed
     */
    public function getSearchSchool($term)
    {
        return School::where([['title', 'LIKE', '%' . $term . '%']])
        ->paginate(25);
    }
}