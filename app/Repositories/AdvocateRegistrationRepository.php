<?php
namespace App\Repositories;
use App\Models\AdvocateRegistration;
use App\Models\BusinessSignupPage;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\AdvocateRegistrationContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder;

/**
 * Class AdvocateRegistrationRepository
 *
 * @package \App\Repositories
 */
class AdvocateRegistrationRepository extends BaseRepository implements AdvocateRegistrationContract
{
    use UploadAble;

    /**
     * AdvocateRegistrationRepository constructor.
     * @param AdvocateRegistration $model
     */
    public function __construct(AdvocateRegistration $model)
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
        $advocate = AdvocateRegistration::where('id',$id)->paginate(25);

        return $advocate;
    }


    /**
     * @return mixed
     */
    public function getSearchRegistration(string $term)
    {
        return AdvocateRegistration::where([['name', 'LIKE', '%' . $term . '%']])
        ->orWhere('email', 'LIKE', '%' . $term . '%')
        ->orWhere('postcode', 'LIKE', '%' . $term . '%')
        ->orWhere('suburb', 'LIKE', '%' . $term . '%')
        ->paginate(25);
    }
}
