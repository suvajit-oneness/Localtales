<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\PinCode;
use App\Models\State;
use App\Models\Suburb;
use Auth;

class PostcodeController extends BaseController
{
	public function index(Request $request)
    {
        $postcodeData = PinCode::where("pin", "LIKE", "%".$request->code."%")->with('state')->leftJoin('suburbs', 'suburbs.pin_code', '=', 'pin_codes.pin')->limit(6)->get();
        $resp = [];

        if ($postcodeData->count() > 0) {
            foreach ($postcodeData as $key => $value) {
                $resp[] = [
                    'pin' => $value->pin,
                    'state_id' => $value->state_id,
                    'state' => $value->state ? $value->state : '',
                    'type'  => 'pin',
                    'short_state'=> $value->short_state ? $value->short_state : '',
                    'suburb' => $value->name ?? '',
                ];
            }
        } else {
            $stateData = State::where("name", "LIKE", "%".$request->code."%")->orWhere("short_code", "LIKE", "%".$request->code."%")->limit(6)->get();

            if ($stateData->count() > 0) {
                foreach ($stateData as $key => $value) {
                    $firstPin = PinCode::where("state_id", $value->id)->first();

                    $resp[] = [
                        // 'pin' => $firstPin->pin,
                        'pin' => '',
                        'state_id' => $value->id,
                        'state' => $value->name,
                        'type' => 'state',
                        'short_state'=> $value->short_code ? $value->short_code : '',
                        'suburb' => '',
                    ];
                }
            } else {
                $suburbData = Suburb::where("name", "LIKE", "%".$request->code."%")->limit(6)->get();

                if ($suburbData->count() > 0) {
                foreach ($suburbData as $key => $value) {
                    $resp[] = [
                        'pin' => $value->pin_code,
                        'state_id' => $value->id,
                        'state' => $value->state,
                        'type' => 'suburb',
                        'short_state'=> $value->short_state,
                        'suburb' => $value->name,
                    ];
                }
            }
            }
        }

        if (count($resp) > 0) {
            return response()->json(['error' => false, 'message' => 'Details found', 'data' => $resp]);
        } else {
            return response()->json(['error' => true, 'message' => 'No details found. Try again!']);
        }
    }
}
