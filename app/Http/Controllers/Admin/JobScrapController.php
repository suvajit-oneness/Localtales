<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\BaseController;
use App\Models\Job;
use App\Models\PinCode;
use App\Models\Suburb;

class JobScrapController extends BaseController
{
    public function index(Request $request)
    {
        $this->setPageTitle('Job Scrap', 'Job');
        return view('admin.job-scrap.index');
    }

    public function storePostcode(Request $request)
    {
        $postcodes = PinCode::orderBy('pin')->get();
        $dataInsertCount = $dataRepeatCount = $totalDataCount = 0;

        foreach($postcodes as $postcodeKey => $postcode) {
            if($postcode->pin < 7009) continue;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"http://demo91.co.in/dev/localtales_job_scrapping/job_scrap_request.php?location=".$postcode->pin);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);
            curl_close ($ch);

            // dd($resp);

            if ($resp) {
                $response = json_decode($resp);
                $totalDataCount = $totalDataCount + count($response);
                foreach($response as $jobKey => $job) {
                    // dd($job);
                    // check if job exists
                    // $jobCheck = Job::where('title', $job->title)->where('company_name', $job->company)->where('location', $job->job_details->location)->first();
                    $jobCheck = Job::where('title', $job->title)->where('company_name', $job->company)->first();

                    if (empty($jobCheck)) {
                        $newJob = new Job();
                        $newJob->title = $job->title;
                        $newJob->slug = slugGenerate($job->title, 'jobs');
                        $newJob->company_name = $job->company ?? '';
                        $newJob->location = $job->job_details->location ?? '';
                        $newJob->category = $job->job_details->category ?? '';
                        $newJob->salary = $job->job_details->salary ?? '';
                        $newJob->employment_type = $job->job_details->job_type ?? '';
                        $newJob->description = $job->job_details->description ?? '';
                        $newJob->link = $job->link ?? '';
                        $newJob->status = 1;

                        // optional
                        $newJob->postcode = $postcode->pin;

                        $newJob->save();
                        $dataInsertCount++;
                    } else {
                        $dataRepeatCount++;
                    }

                    // dd($newJob);
                }
            }
        }

        $message = $dataInsertCount.'/'.$totalDataCount.' data INSERTED. '.$dataRepeatCount.' data EXISTS already';

        // return redirect()->back()->with('success', $message);
        return $this->responseRedirectBack($message ,'success', false, false);
    }

    public function storeSuburb(Request $request)
    {
        // dd('here');
        $suburbs = Suburb::orderBy('name')->get();
        $dataInsertCount = $dataRepeatCount = $totalDataCount = 0;

        foreach($suburbs as $suburbKey => $suburb) {
            // dd($suburb->name);
            // if($suburb->name < 7009) continue;

            $location = $suburb->name.'-'.$suburb->short_state.'-'.$suburb->pin_code;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"http://demo91.co.in/dev/localtales_job_scrapping/job_scrap_request.php?location=".$location);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);
            curl_close ($ch);

            // dd($resp);

            if ($resp) {
                $response = json_decode($resp);

                if(!empty($response) && count($response) > 0) {
                    // $totalDataCount = $totalDataCount + count($resp);
                    foreach($response as $jobKey => $job) {
                        // check if job exists already
                        $jobCheck = Job::where('title', $job->title)->where('company_name', $job->company)->first();

                        if (empty($jobCheck)) {
                            $newJob = new Job();
                            $newJob->title = $job->title;
                            $newJob->slug = slugGenerate($job->title, 'jobs');
                            $newJob->company_name = $job->company ?? '';
                            $newJob->location = $job->job_details->location ?? '';
                            $newJob->category = $job->job_details->category ?? '';
                            $newJob->salary = $job->job_details->salary ?? '';
                            $newJob->employment_type = $job->job_details->job_type ?? '';
                            $newJob->description = $job->job_details->description ?? '';
                            $newJob->link = $job->link ?? '';
                            $newJob->status = 1;

                            // optional
                            $newJob->suburb = $suburb->name;
                            $newJob->postcode = $suburb->pin_code;
                            $newJob->state = $suburb->state;
                            $newJob->short_state = $suburb->short_state;

                            $newJob->save();
                            $dataInsertCount++;
                        } else {
                            // dd($job, $jobCheck);

                            $updateJob = Job::findOrFail($jobCheck->id);
                            $updateJob->title = $job->title;
                            $updateJob->slug = slugGenerate($job->title, 'jobs');
                            $updateJob->company_name = $job->company ?? '';
                            $updateJob->location = $job->job_details->location ?? '';
                            $updateJob->category = $job->job_details->category ?? '';
                            $updateJob->salary = $job->job_details->salary ?? '';
                            $updateJob->employment_type = $job->job_details->job_type ?? '';
                            $updateJob->description = $job->job_details->description ?? '';
                            $updateJob->link = $job->link ?? '';
                            $updateJob->status = 1;

                            // optional
                            $updateJob->suburb = $suburb->name;
                            $updateJob->postcode = $suburb->pin_code;
                            $updateJob->state = $suburb->state;
                            $updateJob->short_state = $suburb->short_state;

                            $updateJob->save();

                            $dataRepeatCount++;
                        }

                        // dd($newJob);
                    }
                }
            }
        }

        $message = $dataInsertCount.'/'.$totalDataCount.' data INSERTED. '.$dataRepeatCount.' data EXISTS already';

        dd($message);

        // return redirect()->back()->with('success', $message);
        // return $this->responseRedirectBack($message ,'success', false, false);
    }
}
