<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\LoopContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class LoopController extends BaseController
{
    /**
     * @var LoopContract
     */
    protected $loopRepository;


    /**
     * PageController constructor.
     * @param LoopContract $loopRepository
     */
    public function __construct(LoopContract $loopRepository){
        $this->loopRepository = $loopRepository;
        
    }

    /**
     * This method is for getting all loop list
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $loops = $this->loopRepository->getLoops();

        return response()->json(compact('loops'));
    }

    /**
     * This method is for getting loop details
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function details($id){
        $loops = $this->loopRepository->detailsLoop($id);
        $loop = $loops[0];

        return response()->json(compact('loop'));
    }

    /**
     * This method is for creating a loop
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $this->validate($request, [
            'user_id'      =>  'required',
            'content'     =>  'required',
        ]);

        $params = $request->except('_token');
        
        $loop = $this->loopRepository->createLoop($params);

        if (!$loop) {
            return response()->json(['error' => 'Loop can not be created'], 400);
        }

        return response()->json(compact('loop'));

    }

    /**
     * This method is for updating a loop
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        $this->validate($request, [
            'content'     =>  'required',
        ]);

        $params = $request->except('_token');
        
        $loop = $this->loopRepository->updateLoop($params);

        if (!$loop) {
            return response()->json(['error' => 'Loop can not be updated'], 400);
        }

        return response()->json(compact('loop'));

    }

    /**
     * This method is for getting user's loops
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function userLoops($userId){
        $loops = $this->loopRepository->userLoops($userId);

        return response()->json(compact('loops'));
    }

    /**
     * This method is for deleting loop
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $loop = $this->loopRepository->deleteLoop($id);

        if (!$loop) {
            return response()->json(['error' => 'Loop can not be deleted'], 400);
        }

        $message = "This loop has been deleted successfully";
        return response()->json(compact('message'),200);
    }

    /**
     * This method is for getting loop comments
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments($id){
        $comments = $this->loopRepository->loopComments($id);

        return response()->json(compact('comments'));
    }

    /**
     * This method is for creating a loop comment
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createComment(Request $request){
        $this->validate($request, [
            'user_id'      =>  'required',
            'loop_id'      =>  'required',
            'comment'     =>  'required',
        ]);

        $params = $request->except('_token');
        
        $comment = $this->loopRepository->createComment($params);

        if (!$comment) {
            return response()->json(['error' => 'Loop comment can not be created'], 400);
        }

        return response()->json(compact('comment'));
    }

    /**
     * This method is for deleting loop comment
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteComment($id)
    {
        $loopComment = $this->loopRepository->deleteLoopComment($id);

        if (!$loopComment) {
            return response()->json(['error' => 'Comment can not be deleted'], 400);
        }

        $message = "This comment has been deleted successfully";
        return response()->json(compact('message'),200);
    }

    /**
     * This method is for managing loop like
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeLoop(Request $request){
        $user_id = $request->user_id;
        $loop_id = $request->loop_id;
        
        $this->loopRepository->likeLoop($user_id,$loop_id);

        $data['message'] = "Loop data has been updated successfully";

        return response()->json(compact('data'));
    }
}