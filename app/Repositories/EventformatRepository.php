<?php
namespace App\Repositories;

use App\Models\Eventformat;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\EventformatContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class EventformatRepository
 *
 * @package \App\Repositories
 */
class EventformatRepository extends BaseRepository implements EventformatContract
{
    use UploadAble;

    /**
     * EventformatRepository constructor.
     * @param Eventformat $model
     */
    public function __construct(Eventformat $model)
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
    public function listEventformats(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findEventformatById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Eventformat|mixed
     */
    public function createEventformat(array $params)
    {
        try {

            $collection = collect($params);

            $eventformat = new Eventformat;
            $eventformat->title = $collection['title'];
            $eventformat->save();

            return $eventformat;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateEventformat(array $params)
    {
        $eventformat = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $eventformat->title = $collection['title'];
        $eventformat->save();

        return $Eventformat;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteEventformat($id)
    {
        $eventformat = $this->findOneOrFail($id);
        $eventformat->delete();
        return $eventformat;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateEventformatStatus(array $params){
        $eventformat = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $eventformat->status = $collection['check_status'];
        $eventformat->save();

        return $eventformat;
    }
}