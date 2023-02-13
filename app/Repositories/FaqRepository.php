<?php
namespace App\Repositories;

use App\Faq;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\FaqContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Str;
/**
 * Class FaqRepository
 *
 * @package \App\Repositories
 */
class FaqRepository extends BaseRepository implements FaqContract
{
    use UploadAble;

    /**
     * BlogCategoryRepository constructor.
     * @param Faq $model
     */
    public function __construct(Faq $model)
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
    public function listfaq(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findfaqById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return State|mixed
     */
    public function createfaq(array $params)
    {
        try {

            $collection = collect($params);

            $faq = new Faq;
            $faq->category = $collection['category'];
            $faq->subcategory = $collection['subcategory'];
            $faq->question = $collection['question'];
            $faq->answer = $collection['answer'];
            $faq->save();

            return $faq;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatefaq(array $params)
    {
        $faq = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $faq->category = $collection['category'];
        $faq->subcategory = $collection['subcategory'];
        $faq->question = $collection['question'];
        $faq->answer = $collection['answer'];

        // $profile_image = $collection['image'];
        // $imageName = time().".".$profile_image->getClientOriginalName();
        // $profile_image->move("categories/",$imageName);
        // $uploadedImage = $imageName;
        // $category->image = $uploadedImage;

        $faq->save();

        return $faq;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deletefaq($id)
    {
        $state = $this->findOneOrFail($id);
        $state->delete();
        return $state;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatefaqStatus(array $params){
        $state = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $state->status = $collection['check_status'];
        $state->save();

        return $state;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsfaq($id)
    {
        $categories = Faq::where('id',$id)->get();

        return $categories;
    }



        // csv upload

    }



