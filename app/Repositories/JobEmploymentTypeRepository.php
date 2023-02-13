<?php
namespace App\Repositories;

use App\Models\JobEmploymentType;
use App\Traits\UploadAble;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Contracts\JobEmploymentTypeContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class JobEmploymentTypeRepository
 *
 * @package \App\Repositories
 */
class JobEmploymentTypeRepository extends BaseRepository implements JobEmploymentTypeContract
{
    use UploadAble;

    /**
     * JobEmploymentTypeRepository constructor.
     * @param JobEmploymentType $model
     */
    public function __construct(JobEmploymentType $model)
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
    public function listType(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findTypeById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return type|mixed
     */
    public function createType(array $params)
    {
        try {
            $collection = collect($params);

            $type = new JobEmploymentType;
            $type->title = $collection['title'] ?? '';
            $type->slug = slugGenerate($collection['title'], 'job_employment_types');
            $type->save();
            // dd($type);

            return $type;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateType(array $params)
    {
        $type = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $type->title = $collection['title']?? '';
        if($type->title != $collection['title']) {
            $type->slug = slugGenerate($collection['title'], 'job_employment_types');
        }
        $type->save();
        return $type;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteType($id)
    {
        $type = $this->findOneOrFail($id);
        $type->delete();
        return $type;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateTypeStatus(array $params){
        $type = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $type->status = $collection['check_status'];
        $type->save();

        return $type;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsType($id)
    {
        $type = JobEmploymentType::where('id',$id)->get();

        return $type;
    }

    public function getSearchType(string $term)
    {
        return JobEmploymentType::where([['title', 'LIKE', '%' . $term . '%']])->paginate(25);
    }
}
