<?php
namespace App\Repositories;
use App\Models\CategoryFaq;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CategoryFaqContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Str;
/**
 * Class CategoryFaqRepository
 *
 * @package \App\Repositories
 */
class CategoryFaqRepository extends BaseRepository implements CategoryFaqContract
{
    use UploadAble;

    /**
     * CategoryFaqRepository constructor.
     * @param CategoryFaq $model
     */
    public function __construct(CategoryFaq $model)
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
    public function listFaqs(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findFaqById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Blog|mixed
     */
    public function createFaq(array $params)
    {
        try {
            $collection = collect($params);

            $blog = new CategoryFaq;
            $blog->category_id = $collection['category_id'];
            $blog->question = $collection['question'] ?? '';
            $blog->answer = $collection['answer'];

            // slug generate
            $blog->save();

            return $blog;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateFaq(array $params)
    {
        $blog = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $blog->question = $collection['question'] ?? '';
        $blog->answer = $collection['answer'];
        $blog->save();

        return $blog;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteFaq($id)
    {
        $blog = $this->findOneOrFail($id);
        $blog->delete();
        return $blog;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateFaqStatus(array $params){
        $blog = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $blog->status = $collection['check_status'];
        $blog->save();

        return $blog;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsFaq($id){
        $blogs = CategoryFaq::with('category')->where('id',$id)->get();
        return $blogs;
    }

}
