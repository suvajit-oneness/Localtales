<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Suburb;

class TestController extends Controller {

	// fetch review from google 
	public function reviewFetch(Request $request) {
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

	// fetch jobs from seek
	public function jobsFetch() {
		// fetch job suburb wise only
		$suburbs = Suburb::orderBy('pin_code', 'asc')->orderBy('name', 'asc')->get();

		foreach($suburbs as $suburb) {
			$location = $suburb->slug.'-'.$suburb->short_state.'-'.$suburb->pin_code;
			$url = "http://demo91.co.in/dev/localtales_job_scrapping/job_scrap_request.php?location=".$location;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL,$url);
			$result = curl_exec($ch);
			curl_close($ch);

			if ($result) {
				$decoded_result = json_decode($result);

				foreach ($decoded_result as $key => $value) {
					DB::table('jobs')->insert([
						'title' => $value->title,
						'slug' => slugGenerate($value->title, 'jobs'),
						'company_name' => $value->company,
						'link' => $value->link,
						'location' => $value->job_details ? $value->job_details->location : '',
						'address' => $value->job_details ? $value->job_details->location : '',
						'category' => $value->job_details ? $value->job_details->category : '',
						'salary' => $value->job_details ? $value->job_details->salary : '',
						'employment_type' => $value->job_details ? $value->job_details->job_type : '',
						'description' => $value->job_details ? $value->job_details->description : '',
						'postcode' => $suburb->pin_code ?? '',
						'suburb' => $suburb->name ?? '',
						'state' => $suburb->state ?? '',
						'short_state' => $suburb->short_state ?? '',
						'status' => 1,
					]);
				}
			}

			// dd(count($decoded_result) . ' jobs done for ' . $suburb->name);
		}
	}

}