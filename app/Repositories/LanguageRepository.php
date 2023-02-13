<?php
namespace App\Repositories;

use App\Models\Language;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\LanguageContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class LanguageRepository
 *
 * @package \App\Repositories
 */
class LanguageRepository extends BaseRepository implements LanguageContract
{
    use UploadAble;

    /**
     * LanguageRepository constructor.
     * @param Language $model
     */
    public function __construct(Language $model)
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
    public function listLanguages(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findLanguageById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Language|mixed
     */
    public function createLanguage(array $params)
    {
        try {

            $collection = collect($params);

            $language = new Language;
            $language->title = $collection['title'];
            $language->save();

            return $language;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLanguage(array $params)
    {
        $language = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $language->title = $collection['title'];
        $language->save();

        return $language;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteLanguage($id)
    {
        $language = $this->findOneOrFail($id);
        $language->delete();
        return $language;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLanguageStatus(array $params){
        $language = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $language->status = $collection['check_status'];
        $language->save();

        return $language;
    }
}