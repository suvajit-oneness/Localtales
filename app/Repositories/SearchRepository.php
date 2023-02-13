<?php
namespace App\Repositories;

use App\Models\Blog;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\SearchContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class ContactRepository
 *
 * @package \App\Repositories
 */
class SearchRepository extends BaseRepository implements SearchContract
{
    use UploadAble;

    /**
     * SearchRepository constructor.
     * @param Blog $model
     */
    public function __construct(Blog $model)
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
      public function index(array $data)
      {
        $collectedData = collect($data);

        $data = Blog::where('blog_category_id', 'like', '%'.$collectedData.'%')
        ->orWhere('suburb_id', 'like', '%'.$collectedData.'%')
        ->orWhere('pincode', 'like', '%'.$collectedData.'%')
        ->orWhere('title', 'like', '%'.$collectedData.'%')
        ->orWhere('content', 'like', '%'.$collectedData.'%')
        ->get();

        return $data;
      }





}
