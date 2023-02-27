<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller {
	function reviewFetch(Request $request) {
		$data = DB::select("SELECT id, google_api_detail_fetch FROM directories_wt_google_api_detail WHERE google_api_detail_fetch IS NOT NULL AND id >= 300000");

		foreach($data as $directory) {
			$directoryId = $directory->id;
			$apiData = $directory->google_api_detail_fetch;
			$decodeAPIData = json_decode($apiData);

			$reviews = [];

			if (!empty($decodeAPIData->result->reviews)) {
				$reviews = $decodeAPIData->result->reviews;
			}

			if (!empty($reviews) && count($reviews) > 0) {
				foreach($reviews as $key => $item) {

					// check if review exists
					// $reviewCheck = DB::table('reviews')
					// ->where('author_name', $item->author_name)
					// ->where('directory_id', $directoryId)
					// ->where('time', $item->time)
					// ->first();

					// if (empty($reviewCheck)) {
						DB::table('reviews')->insert([
							'directory_id' => $directoryId,
							'user_id' => 0,
							'author_name' => $item->author_name ?? '',
							'author_url' => $item->author_url ?? '',
							'language' => $item->language ?? '',
							'original_language' => $item->original_language ?? '',
							'profile_photo_url' => $item->profile_photo_url ?? '',
							'rating' => $item->rating ?? '',
							'relative_time_description' => $item->relative_time_description ?? '',
							'text' => $item->text ?? '',
							'time' => $item->time ?? '',
							'translated' => $item->translated ?? '',
							'total_rating' => $item->total_rating ?? '',
							'type' => 'google_review',
							'status' => 1,
							'created_at' => $item->time ? date('Y-m-d H:i:s', $item->time) : date('Y-m-d H:i:s'),
						]);
					// }
				}
			}
		}

    }

}