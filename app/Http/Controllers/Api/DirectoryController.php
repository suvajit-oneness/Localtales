<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Userbusiness;
use Auth;

class DirectoryController extends BaseController
{
	public function save(Request $request) {
        $ip = $_SERVER['REMOTE_ADDR'];

	    // check if collection already exists
        if(auth()->guard('user')->check()) {
           $collectionExistsCheck = Userbusiness::where('directory_id', $request->id)->where('ip', $ip)->orWhere('user_id', auth()->guard('user')->user()->id)->first();
        } else {
           $collectionExistsCheck = Userbusiness::where('directory_id', $request->id)->where('ip', $ip)->first();
        }

        if($collectionExistsCheck != null) {
            // if found
            $data = Userbusiness::destroy($collectionExistsCheck->id);
            return response()->json(['status' => 200, 'type' => 'remove', 'message' => 'Directory removed from saved']);
        } else {
            // if not found
            $data = new Userbusiness();
            $data->user_id = auth()->guard('user')->user() ? auth()->guard('user')->user()->id : 0;
            $data->directory_id = $request->id;
            $data->ip = $ip;
            $data->save();

            return response()->json(['status' => 200, 'type' => 'add', 'message' => 'Directory saved']);
        }
	}
}