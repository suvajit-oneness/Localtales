<?php
namespace App\Repositories;
use App\Models\EventOrganiser;
use App\Models\BusinessSignupPage;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\EventRegistrationContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder;

/**
 * Class EventRegistrationRepository
 *
 * @package \App\Repositories
 */
class EventRegistrationRepository extends BaseRepository implements EventRegistrationContract
{
    use UploadAble;

    /**
     * EventRegistrationRepository constructor.
     * @param EventOrganiser $model
     */
    public function __construct(EventOrganiser $model)
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
    public function listRegistration(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findRegistrationById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }


    /**
     * @param $id
     * @return mixed
     */
    public function detailsRegistration($id)
    {
        $advocate = EventOrganiser::where('id',$id)->paginate(25);

        return $advocate;
    }


    /**
     * @return mixed
     */
    public function getSearchRegistration(string $term)
    {
        return EventOrganiser::where([['name', 'LIKE', '%' . $term . '%']])
        ->orWhere('email', 'LIKE', '%' . $term . '%')
        ->orWhere('postcode', 'LIKE', '%' . $term . '%')
        ->orWhere('suburb', 'LIKE', '%' . $term . '%')
        ->paginate(25);
    }
}
