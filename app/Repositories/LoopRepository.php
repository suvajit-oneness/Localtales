<?php
namespace App\Repositories;

use App\Models\Loop;
use App\Models\Loopcomment;
use App\Models\Looplike;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\LoopContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class LoopRepository
 *
 * @package \App\Repositories
 */
class LoopRepository extends BaseRepository implements LoopContract
{
    use UploadAble;

    /**
     * LoopRepository constructor.
     * @param Loop $model
     */
    public function __construct(Loop $model)
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
    public function listLoops(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findLoopById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Loop|mixed
     */
    public function createLoop(array $params)
    {
        try {

            $collection = collect($params);

            $loop = new Loop;
            $loop->content = $collection['content'];
            $loop->user_id = $collection['user_id'];
            $loop->no_of_likes = 0;
            $loop->no_of_dislikes = 0;
            $loop->no_of_comments = 0;
            $loop->status = 1;
            
            $loop->save();

            return $loop;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLoop(array $params)
    {
        $loop = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $loop->content = $collection['content'];

        $loop->save();

        return $loop;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteLoop($id)
    {
        $loop = $this->findOneOrFail($id);
        $loop->delete();
        return $loop;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLoopStatus(array $params){
        $loop = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $loop->status = $collection['check_status'];
        $loop->save();

        return $loop;
    }

    /**
     * @return mixed
     */
    public function getLoops(){
        $loops = Loop::with('user')->with('comments')->with('likes')->get();

        return $loops;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsLoop($id)
    {
        $loops = Loop::with('user')->with('comments')->with('likes')->where('id',$id)->get();
        
        return $loops;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function userLoops($userId){
        $loops = Loop::with('user')->with('comments')->with('likes')->where('user_id',$userId)->get();

        return $loops;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function loopComments($id)
    {
        $comments = Loopcomment::with('user')->with('loop')->where('loop_id',$id)->get();
        
        return $comments;
    }

    /**
     * @param array $params
     * @return Loop|mixed
     */
    public function createComment(array $params)
    {
        try {

            $collection = collect($params);

            $loopComment = new Loopcomment;
            $loopComment->comment = $collection['comment'];
            $loopComment->user_id = $collection['user_id'];
            $loopComment->loop_id = $collection['loop_id'];
            $loopComment->status = 1;
            
            $loopComment->save();

            return $loopComment;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteLoopComment($id)
    {
        $loopComment = Loopcomment::findOrFail($id);
        $loopComment->delete();
        return $loopComment;
    }

    /**
     * @param $userId
     * @param $loopId
     * @return bool
     */
    public function likeLoop($userId,$loopId){
        $result = Looplike::where('user_id',$userId)->where('loop_id',$loopId)->get();

        if(count($result)>0){
            Looplike::where("loop_id",$loopId)->where("user_id",$userId)->delete();
        }else{
            $loopLike = new Looplike;
            $loopLike->loop_id = $loopId;
            $loopLike->user_id = $userId;

            $loopLike->save();
        }

        return true;
    }
}