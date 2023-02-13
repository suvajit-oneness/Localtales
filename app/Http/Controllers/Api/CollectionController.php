<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\UserCollection;
use Auth;

class CollectionController extends BaseController
{
	public function save(Request $request) {
        $ip = $_SERVER['REMOTE_ADDR'];

	    // check if collection already exists
        if(auth()->guard('user')->check()) {
           $collectionExistsCheck = UserCollection::where('collection_id', $request->id)->where('ip', $ip)->orWhere('user_id', auth()->guard('user')->user()->id)->first();
        } else {
           $collectionExistsCheck = UserCollection::where('collection_id', $request->id)->where('ip', $ip)->first();
        }

        if($collectionExistsCheck != null) {
            // if found
            $data = UserCollection::destroy($collectionExistsCheck->id);
            return response()->json(['status' => 200, 'type' => 'remove', 'message' => 'Collection removed from saved']);
        } else {
            // if not found
            $data = new UserCollection();
            $data->user_id = auth()->guard('user')->user() ? auth()->guard('user')->user()->id : 0;
            $data->collection_id = $request->id;
            $data->ip = $ip;
            $data->save();

            return response()->json(['status' => 200, 'type' => 'add', 'message' => 'Collection saved']);
        }
	}
}