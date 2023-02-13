<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\PinCode;
use App\Models\State;
use App\Models\Suburb;
use Auth;
use DB;

class PostcodeController extends BaseController
{
	public function index(Request $request)
    {
        //$postcodeData = PinCode::where("pin", "LIKE", $request->code."%")->with('state')->leftJoin('suburbs', 'suburbs.pin_code', '=', 'pin_codes.pin')->orderBy('pin_codes.pin','asc')->limit(30)->get();
        $postcodeData = PinCode::where("pin", "LIKE", $request->code."%")->orderBy('pin_codes.pin','asc')->limit(30)->get();
        $stateData = State::where("name", "LIKE", $request->code."%")->orWhere("short_code", "LIKE", $request->code."%")->limit(30)->get();
        $suburbData = Suburb::where("name", "LIKE", $request->code."%")->limit(30)->orderBy('name','asc')->get();

        // $postcodeData = PinCode::where("pin", "LIKE", "%".$request->code."%")->with('state')->leftJoin('suburbs', 'suburbs.pin_code', '=', 'pin_codes.pin')->limit(6)->get();
        // $stateData = State::where("name", "LIKE", "%".$request->code."%")->orWhere("short_code", "LIKE", "%".$request->code."%")->limit(6)->get();
        // $suburbData = Suburb::where("name", "LIKE", "%".$request->code."%")->limit(6)->get();

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
        }
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
        }
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

        if (count($resp) > 0) {
            return response()->json(['error' => false, 'message' => 'Details found', 'data' => $resp]);
        } else {
            return response()->json(['error' => true, 'message' => 'No details found. Try again!']);
        }
    }

    public function category(Request $request) {
        $data = $request->data;

        // primary category fetch
        $resp = [];

        $primaryCat = DB::table('directory_categories')->where('parent_category', 'like', $data.'%')->where('type', 1)->where('status', 1)->limit(1)->get();

        $secondaryCat = DB::table('directory_categories')->where('child_category', 'like', $data.'%')->where('type', 0)->where('status', 1)->groupBy('child_category')->limit(6)->get();

        $directoriesCat = DB::table('directories')->where('name', 'like', $data.'%')->groupBy('name')->limit(6)->get();
        //dd($directoriesCat);

        if (count($primaryCat) > 0) {
            foreach($primaryCat as $value) {
                $childCategoriesGrouped = DB::table('directory_categories')->select('id', 'child_category','child_category_slug')->where('parent_category', $value->parent_category)->where('type', 0)->groupBy('child_category')->limit(6)->get();

                $resp[] = [
                    'type' => 'primary',
                    'id' => $value->id,
                    'title' => $value->parent_category,
                    'slug' => $value->parent_category_slug,
                    'child' => $childCategoriesGrouped
                ];
            }
        }

        if (count($secondaryCat) > 0) {
            foreach($secondaryCat as $value) {
                // $directories = DB::table('directories')->select('id', 'name')->where('category_id', 'like', $value->id.'%')->where('status', 1)->limit(6)->get();
                $directories = DB::select("SELECT id, name AS child_category, category_id, slug FROM directories where category_id like '$value->id,%' or category_id like '%,$value->id,%' limit 6");

                $resp[] = [
                    'type' => 'secondary',
                    'id' => $value->id,
                    'title' => $value->child_category,
                    'slug' => $value->child_category_slug,
                    'child' => $directories
                ];
            }
        }
        /*
        if (count($directoriesCat) > 0) {
            foreach($directoriesCat as $value) {
                // $directories = DB::table('directories')->select('id', 'name')->where('category_id', 'like', $value->id.'%')->where('status', 1)->limit(6)->get();
                $resp[] = [
                    'type' => 'business',
                    'id' => $value->id,
                    'title' => $value->name,
                    'slug' => $value->slug,
                    'child' => ''
                ];
            }
        }
        */
        if (count($resp) > 0) {
            return response()->json(['error' => false, 'message' => 'Details found', 'data' => $resp]);
        } else {
            return response()->json(['error' => true, 'message' => 'No details found. Try again!']);
        }
    }
}
