<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\Directory;
use Illuminate\Support\Str;

class TestController extends BaseController
{
    public function import(Request $request)
    {
        return view('admin.test.import');
    }

    public function importPost(Request $request)
    {
        // dd($request->all());

        $row = 1;
        if (($handle = fopen($request->file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if($row < 363) continue;

                // dd($row);

                $num = count($data);
                // echo "<p> $num fields in line $row: <br /></p>\n";
                // for ($c=0; $c < $num; $c++) {
                    // echo $data[$c] . "<br />\n";

                    $directoryCheck = Directory::select('id')->where('name', $data[0])->where('category_id', '1567,')->first();

                    // if directory found
                    if (!empty($directoryCheck)) {
                        $category = $data[1];
                        $explodedCat = explode(',', $category);
                        // dd($explodedCat);

                        $updatedCategory = '';
                        foreach($explodedCat as $key => $singleCat) {
                            if($singleCat == " Community & Other Education") $singleCat = "Community & Other Education";

                            $categoryCheck = DB::table('directory_categories')->select('id')->where('title', 'like', '%'.$singleCat.'%')->first();

                            $updatedCategory .= $categoryCheck->id.',';
                        }
                        // dd($updatedCategory);

                        // update directory
                        $directoryUpdate = Directory::where('id', $directoryCheck->id)->update([
                            'category_id' => $updatedCategory
                        ]);
                    }
                // }
            }
            fclose($handle);
        }
    }

    public function allDirectory(Request $request)
    {
        $currentPage = $request->page;
        $per_page = 10000;
        $offset = ($currentPage - 1) * $per_page;

        $directories = DB::select("SELECT * FROM directories_sorted_2 WHERE match_not_found = 1 AND is_verified = 1 LIMIT $per_page OFFSET $offset");
        print_r(json_encode($directories));exit();
    }

    public function fetch(Request $request, $page)
    {
        $url = "http://54.206.45.247/fetch/staging/all/directory?page=".$page;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);
        curl_close ($ch);

        $resp = json_decode($resp);

        // dd($resp);

        $insertCount = 0;
        foreach($resp as $val) {
            // dd($val);
            $check = DB::table('directories')->where('name', $val->name)->first();

            if (empty($check)) {
                $insertCount++;
                
                DB::table('directories')->insert([
                    // 'id' => $val->id,
                    'name' => $val->name,
                    'category_id' => $val->category_id,
                    'google_category_display' => $val->google_category_display,
                    'google_category' => $val->google_category,
                    'place_id' => $val->place_id,
                    'google_api_detail_fetch' => $val->google_api_detail_fetch,
                    'trading_name' => $val->trading_name,
                    'title' => $val->title,
                    'slug' => $val->slug,
                    'image' => $val->image,
                    'banner_image' => $val->banner_image,
                    'image2' => $val->image2,
                    'email' => $val->email,
                    'password' => $val->password,
                    'mobile' => $val->mobile,
                    'alternate_mobile' => $val->alternate_mobile,
                    'primary_name' => $val->primary_name,
                    'primary_email' => $val->primary_email,
                    'primary_phone' => $val->primary_phone,
                    'address' => $val->address,
                    'establish_year' => $val->establish_year,
                    'ABN' => $val->ABN,
                    'monday' => $val->monday,
                    'tuesday' => $val->tuesday,
                    'wednesday' => $val->wednesday,
                    'thursday' => $val->thursday,
                    'friday' => $val->friday,
                    'saturday' => $val->saturday,
                    'sunday' => $val->sunday,
                    'public_holiday' => $val->public_holiday,
                    'category_tree' => $val->category_tree,
                    'content' => $val->content,
                    'pin' => $val->pin,
                    'lat' => $val->lat,
                    'lon' => $val->lon,
                    'description' => $val->description,
                    'service_description' => $val->service_description,
                    'opening_hour' => $val->opening_hour,
                    'website' => $val->website,
                    'rating' => $val->rating,
                    'total_reviews' => $val->total_reviews,
                    'facebook_link' => $val->facebook_link,
                    'twitter_link' => $val->twitter_link,
                    'instagram_link' => $val->instagram_link,
                    'url' => $val->url,
                    'business_mail_sent' => $val->business_mail_sent,
                    'mail_redirect_update' => $val->mail_redirect_update,
                    'meta_title' => $val->meta_title,
                    'meta_description' => $val->meta_description,
                    'status' => $val->status,
                    'is_verified' => $val->is_verified,
                    'match_status' => $val->match_status,
                    'match_status_detail' => $val->match_status_detail,
                    'match_not_found' => $val->match_not_found,
                    'is_deleted' => $val->is_deleted,
                    'remember_token' => $val->remember_token,
                    'created_at' => $val->created_at,
                    'updated_at' => $val->updated_at,
                ]);
                
                // Directory::where('id', $val->id)->delete();
                // dd('done');
            }
        }

        dd($insertCount.' data inserted');

        // dd(json_decode($resp));

        // echo '<pre>';print_r(json_decode($resp[0]));exit();
    }

    public function allDirectory_old(Request $request)
    {
        $currentPage = $request->page;
        $per_page = 10000;
        $offset = ($currentPage - 1) * $per_page;

        $directories = DB::select("SELECT * FROM directories WHERE match_not_found = 1 AND is_verified = 1 LIMIT $per_page OFFSET $offset");
        print_r(json_encode($directories));exit();
    }

    public function fetch_old(Request $request, $page)
    {
        $url = "http://13.211.190.220/fetch/staging/all/directory?page=".$page;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);
        curl_close ($ch);

        $resp = json_decode($resp);

        // dd($resp);

        $insertCount = 0;
        foreach($resp as $val) {
            // dd($val);
            $check = DB::table('directories_sorted_2')->where('id', $val->id)->where('name', $val->name)->first();

            if (empty($check)) {
                $insertCount++;
                
                DB::table('directories_sorted_2')->insert([
                    'id' => $val->id,
                    'name' => $val->name,
                    'category_id' => $val->category_id,
                    'google_category_display' => $val->google_category_display,
                    'google_category' => $val->google_category,
                    'place_id' => $val->place_id,
                    'google_api_detail_fetch' => $val->google_api_detail_fetch,
                    'trading_name' => $val->trading_name,
                    'title' => $val->title,
                    'slug' => $val->slug,
                    'image' => $val->image,
                    'banner_image' => $val->banner_image,
                    'image2' => $val->image2,
                    'email' => $val->email,
                    'password' => $val->password,
                    'mobile' => $val->mobile,
                    'alternate_mobile' => $val->alternate_mobile,
                    'primary_name' => $val->primary_name,
                    'primary_email' => $val->primary_email,
                    'primary_phone' => $val->primary_phone,
                    'address' => $val->address,
                    'establish_year' => $val->establish_year,
                    'ABN' => $val->ABN,
                    'monday' => $val->monday,
                    'tuesday' => $val->tuesday,
                    'wednesday' => $val->wednesday,
                    'thursday' => $val->thursday,
                    'friday' => $val->friday,
                    'saturday' => $val->saturday,
                    'sunday' => $val->sunday,
                    'public_holiday' => $val->public_holiday,
                    'category_tree' => $val->category_tree,
                    'content' => $val->content,
                    'pin' => $val->pin,
                    'lat' => $val->lat,
                    'lon' => $val->lon,
                    'description' => $val->description,
                    'service_description' => $val->service_description,
                    'opening_hour' => $val->opening_hour,
                    'website' => $val->website,
                    'rating' => $val->rating,
                    'total_reviews' => $val->total_reviews,
                    'facebook_link' => $val->facebook_link,
                    'twitter_link' => $val->twitter_link,
                    'instagram_link' => $val->instagram_link,
                    'url' => $val->url,
                    'business_mail_sent' => $val->business_mail_sent,
                    'mail_redirect_update' => $val->mail_redirect_update,
                    'meta_title' => $val->meta_title,
                    'meta_description' => $val->meta_description,
                    'status' => $val->status,
                    'is_verified' => $val->is_verified,
                    'match_status' => $val->match_status,
                    'match_status_detail' => $val->match_status_detail,
                    'match_not_found' => $val->match_not_found,
                    'is_deleted' => $val->is_deleted,
                    'remember_token' => $val->remember_token,
                    'created_at' => $val->created_at,
                    'updated_at' => $val->updated_at,
                ]);
                
                // Directory::where('id', $val->id)->delete();
                // dd('done');
            }
        }

        dd($insertCount.' data inserted');

        // dd(json_decode($resp));

        // echo '<pre>';print_r(json_decode($resp[0]));exit();
    }

    public function directoryDataUpload(Request $request)
    {
        // page 3
        $allStageData = DB::select("SELECT * FROM directories_sorted_2 LIMIT 10000 OFFSET 20000");

        // dd($allStageData);

        foreach($allStageData as $val) {
            $check = DB::table('directories')->select('id')->where('name', $val->name)->where('category_id', $val->category_id)->first();

            // dd($check);

            if (empty($check)) {
                DB::table('directories')->insert([
                    // 'id' => $val->id,
                    'name' => $val->name,
                    'category_id' => $val->category_id,
                    'google_category_display' => $val->google_category_display,
                    'google_category' => $val->google_category,
                    'place_id' => $val->place_id,
                    'google_api_detail_fetch' => $val->google_api_detail_fetch,
                    'trading_name' => $val->trading_name,
                    'title' => $val->title,
                    'slug' => $val->slug,
                    'image' => $val->image,
                    'banner_image' => $val->banner_image,
                    'image2' => $val->image2,
                    'email' => $val->email,
                    'password' => $val->password,
                    'mobile' => $val->mobile,
                    'alternate_mobile' => $val->alternate_mobile,
                    'primary_name' => $val->primary_name,
                    'primary_email' => $val->primary_email,
                    'primary_phone' => $val->primary_phone,
                    'address' => $val->address,
                    'establish_year' => $val->establish_year,
                    'ABN' => $val->ABN,
                    'monday' => $val->monday,
                    'tuesday' => $val->tuesday,
                    'wednesday' => $val->wednesday,
                    'thursday' => $val->thursday,
                    'friday' => $val->friday,
                    'saturday' => $val->saturday,
                    'sunday' => $val->sunday,
                    'public_holiday' => $val->public_holiday,
                    'category_tree' => $val->category_tree,
                    'content' => $val->content,
                    'pin' => $val->pin,
                    'lat' => $val->lat,
                    'lon' => $val->lon,
                    'description' => $val->description,
                    'service_description' => $val->service_description,
                    'opening_hour' => $val->opening_hour,
                    'website' => $val->website,
                    'rating' => $val->rating,
                    'total_reviews' => $val->total_reviews,
                    'facebook_link' => $val->facebook_link,
                    'twitter_link' => $val->twitter_link,
                    'instagram_link' => $val->instagram_link,
                    'url' => $val->url,
                    'business_mail_sent' => $val->business_mail_sent,
                    'mail_redirect_update' => $val->mail_redirect_update,
                    'meta_title' => $val->meta_title,
                    'meta_description' => $val->meta_description,
                    'status' => $val->status,
                    'is_verified' => $val->is_verified,
                    'match_status' => $val->match_status,
                    'match_status_detail' => $val->match_status_detail,
                    'match_not_found' => $val->match_not_found,
                    'is_deleted' => $val->is_deleted,
                    'remember_token' => $val->remember_token,
                    'created_at' => $val->created_at,
                    'updated_at' => $val->updated_at,
                ]);
            }

            // dd($val->name.' data uploaded');
        }
    }

    public function jobSlugUpdate(Request $request)
    {
        $duplicateSlugData = DB::select("SELECT slug, COUNT(slug)
        FROM `jobs`
        GROUP BY slug
        HAVING COUNT(slug) > 1
        ORDER BY COUNT(slug) DESC");

        foreach($duplicateSlugData as $item) {
            $singleSlugHandlingData = DB::select("SELECT id, title, slug FROM jobs WHERE slug = '$item->slug'");
            
            foreach($singleSlugHandlingData as $val) {
                // $newSlug = slugGenerateUPDATED($val->title, 'jobs');

                $slug = Str::slug($val->title, '-');
                // $slugExistCount = DB::table('jobs')->where('title', $val->title)->count();
                // if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
                // // dd($slug);
                // // this generated slug maybe already existed in db
                // $slugExist = DB::table('jobs')->where('slug', $slug)->count();
                // if ($slugExist > 0) $slug = $slug.'-'.($slugExist + 1);

                $updateSlug = DB::select("UPDATE jobs SET slug = '$slug-$val->id' WHERE id = '$val->id'");

                // dd($updateSlug);
            }
        }
        dd('here');
    }
}
