<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function index()
    {
        $week_start = getStartAndEndDate()['start'];
        $week_end = getStartAndEndDate()['end'];
        $week_end_plus_one = date('Y-m-d', strtotime(getStartAndEndDate()['end'].'+1day'));
        $directory_id = Auth::guard('business')->user()->id;

        $data = DB::table('directory_visits')
        ->selectRaw('SUM(count) as total_visit')
        ->where('directory_id', $directory_id)
        ->where('created_at', '>=', $week_start)
        ->where('created_at', '<=', $week_end_plus_one)
        ->first();

        // store in visit log
        $logChk = DB::table('directory_visit_logs')
        ->where('week_start', $week_start)
        ->where('week_end', $week_end)
        ->first();

        // if no log found
        if (empty($logChk)) {
            $newLog = DB::table('directory_visit_logs')->insert([
                'directory_id' => $directory_id,
                'week_start' => $week_start,
                'week_end' => $week_end,
                'count' => $data->total_visit,
            ]);
        }
        // if log found, update with UPDATED/ INCREASED COUNT
        else {
            $newLog = DB::table('directory_visit_logs')->where('id', $logChk->id)->update([
                'count' => $data->total_visit,
            ]);
        }

        // notification fires on sundays/ week ends
        $current_date = date('Y-m-d');

        if ($current_date == $week_end) {
            $shareData = (object)[];
            $shareData->week_start = $week_start;
            $shareData->week_end = $week_end;
            $shareData->count = $data->total_visit;

            // Notify Diretcory about weekly visit count
            /**
             * @param int $directoryId
             * @param string $type
             * @param object $data
             */
            directoryNotify($directory_id, 'weekly-visit-count', $shareData);
        }


    }

}
