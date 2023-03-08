<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Suburb;

class PostcodeController extends Controller
{
    public function detail(Request $request)
    {
        $data = Suburb::select('name', 'short_state', 'pin_code')->where('pin_code', $request->postcode)->get();

        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Postcode details found',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Postcode details not found'
            ]);
        }
    }

}
