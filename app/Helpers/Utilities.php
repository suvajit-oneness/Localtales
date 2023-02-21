<?php

use App\Models\ArticleFaq;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Directory;
use App\Models\PinCode;
use App\Models\State;
use App\Models\SubCategory;
use App\Models\Suburb;
use App\Models\User;
use App\Models\MailLog;
use App\Models\DealReview;
use App\Models\ReviewVote;
use App\Models\Activity;
use Illuminate\Support\Facades\Mail;

if (!function_exists('sidebar_open')) {
    function sidebar_open($routes = []) {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

    return $open ? 'active' : '';
    }
}

if (!function_exists('imageResizeAndSave')) {
    function imageResizeAndSave($imageUrl, $type = 'categories', $filename)
    {
        if (!empty($imageUrl)) {

            //save 60x60 image
            \Storage::disk('public')->makeDirectory($type.'/60x60');
            $path60X60     = storage_path('app/public/'.$type.'/60x60/'.$filename);
            $canvas = \Image::canvas(60, 60);
            $image = \Image::make($imageUrl)->resize(60, 60,
                    function($constraint) {
                        $constraint->aspectRatio();
                    });
            $canvas->insert($image, 'center');
            $canvas->save($path60X60, 70);

            //save 350X350 image
            \Storage::disk('public')->makeDirectory($type.'/350x350');
            $path350X350     = storage_path('app/public/'.$type.'/350x350/'.$filename);
            $canvas = \Image::canvas(350, 350);
            $image = \Image::make($imageUrl)->resize(350, 350,
                    function($constraint) {
                        $constraint->aspectRatio();
                    });
            $canvas->insert($image, 'center');
            $canvas->save($path350X350, 75);

            return $filename;
        } else { return false; }
    }
}

if(!function_exists('directoryRatingHtml')) {
    function directoryRatingHtml($rating = null) {
        if ($rating == 0) {
            $resp = '<p>No ratings available</p>';
        } elseif ($rating == 1) {
            $resp = '
            <p class="review">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <small>'.$rating.' Rating</small>
            </p>
            ';
        } elseif ($rating > 1 && $rating < 2) {
            $resp = '
            <p class="review">
                <span class="fa fa-star checked"></span>
                <span class="fas fa-star-half-alt" style="color:#FFA701"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <small>'.$rating.' Ratings</small>
            </p>
            ';
        } elseif ($rating == 2) {
            $resp = '
            <p class="review">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <small>'.$rating.' Ratings</small>
            </p>
            ';
        } elseif ($rating > 2 && $rating < 3) {
            $resp = '
            <p class="review">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fas fa-star-half-alt" style="color:#FFA701"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <small>'.$rating.' Ratings</small>
            </p>
            ';
        } elseif ($rating == 3) {
            $resp = '
            <p class="review">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star "></span>
                <span class="fa fa-star"></span>
                <small>'.$rating.' Ratings</small>
            </p>
            ';
        } elseif ($rating > 3 && $rating < 4) {
            $resp = '
            <p class="review">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star-half-alt" style="color:#FFA701"></span>
                <span class="fa fa-star"></span>
                <small>'.$rating.' Ratings</small>
            </p>
            ';
        } elseif ($rating == 4) {
            $resp = '
            <p class="review">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <small>'.$rating.' Ratings</small>
            </p>
            ';
        } elseif ($rating > 4 && $rating < 5) {
            $resp = '
            <p class="review">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star-half-alt" style="color:#FFA701"></span>
                <small>'.$rating.' Ratings</small>
            </p>
            ';
        } else {
            $resp = '
            <p class="review">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <small>'.$rating.' Ratings</small>
            </p>
            ';
        }

        return $resp;
    }
}

function CountUsers(){
    return User::where('status','1')->count();
}

function CountState(){
    return State::count();
}
function CountSuburb()
{
    return Suburb::count();
}
function CountPostcode()
{
    return PinCode::count();
}
function CountDirectory()
{
    return Directory::count();
}
function CountCollection()
{
    return Collection::count();
}
function CountCategory()
{
    return Category::count();
}
function CountSubCategory()
{
    return SubCategory::count();
}
function CountArticles()
{
    return ArticleFaq::count();
}

if(!function_exists('directoryCategory')){
    function directoryCategory($category_id) {
        if(!empty($category_id)) {
            $cat = substr($category_id, 0, -1);
            $displayCategoryName = '   ';

            $childCatArr = [];
            foreach(explode(',', $cat) as $catKey => $catVal) {
                $catDetails = \App\Models\DirectoryCategory::where('id', $catVal)->where('status', 1)->first();

                if(!empty($catDetails->child_category)) {

                    if( !in_array($catDetails->child_category, $childCatArr) ) {
                        array_push($childCatArr, $catDetails->child_category);

                        $displayCategoryName .= '<a class="" href="'.URL::to('category/'.$catDetails->child_category_slug).'">'.$catDetails->child_category.'</a>, ';
                    }

                    // if(!in_array($catDetails->child_category, $childCatArr)) {
                    //     $displayCategoryName .= '<a class="mb-2" href="'.URL::to('category/'.$catDetails->child_category_slug).'">'.$catDetails->child_category.'</a>';
                    // }

                    // $displayCategoryName .= '<a class="" href="'.URL::to('category/'.$catDetails->child_category_slug).'">'.$catDetails->child_category.'</a>, ';
                }
                /* else {
                    $displayCategoryName .= '<a class="" href="'.URL::to('category/'.$catDetails->slug).'">'.$catDetails->title.'</a>, ';
                }*/
            }

            // dd($childCatArr);

            $displayCategoryName = substr($displayCategoryName, 0, -2);
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}

if(!function_exists('directoryCategoryStr')){
    function directoryCategoryStr($category_id) {
        if(!empty($category_id)) {
            $cat = substr($category_id, 0, -1);
            $displayCategoryName = '';
            foreach(explode(',', $cat) as $catKey => $catVal) {
                $catDetails = \App\Models\DirectoryCategory::where('id', $catVal)->where('status', 1)->first();

                if(!empty($catDetails->child_category)) {
                    $displayCategoryName .= $catDetails->child_category.', ';
                }
                /* else {
                    $displayCategoryName .= '<a class="" href="'.URL::to('category/'.$catDetails->slug).'">'.$catDetails->title.'</a>, ';
                }*/
            }
            $displayCategoryName = substr($displayCategoryName, 0, -2);
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}

if(!function_exists('directoryParentChildCategoryStr')){
    function directoryParentChildCategoryStr($category_id) {
        if(!empty($category_id)) {
            $cat = substr($category_id, 0, -1);
            $displayCategoryName = '';
            foreach(explode(',', $cat) as $catKey => $catVal) {
                $catDetails = \App\Models\DirectoryCategory::where('id', $catVal)->where('status', 1)->first();

                if(!empty($catDetails->child_category)) {
                    $displayCategoryName .= '<strong>'.$catDetails->parent_category.'</strong> > '.$catDetails->child_category.'<br> ';
                }

                /* else {
                    $displayCategoryName .= '<a class="" href="'.URL::to('category/'.$catDetails->slug).'">'.$catDetails->title.'</a>, ';
                }*/
            }
            $displayCategoryName = substr($displayCategoryName, 0, -2);
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}

if(!function_exists('directoryParentChildCategoryCSV')){
    function directoryParentChildCategoryCSV($category_id) {
        if(!empty($category_id)) {
            $cat = substr($category_id, 0, -1);
            $displayCategoryName = '';
            foreach(explode(',', $cat) as $catKey => $catVal) {
                $catDetails = \App\Models\DirectoryCategory::where('id', $catVal)->where('status', 1)->first();

                if(!empty($catDetails->child_category)) {
                    $displayCategoryName .= $catDetails->parent_category.' > '.$catDetails->child_category."\n";
                }
            }
            $displayCategoryName = substr($displayCategoryName, 0, -2);
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}

if(!function_exists('csvdirectoryCategoryStr')){
    function csvdirectoryCategoryStr($category_id) {
        if(!empty($category_id)) {
            $cat = substr($category_id, 0, -1);
            $displayCategoryName = '';
            foreach(explode(',', $cat) as $catKey => $catVal) {
                $catDetails = \App\Models\DirectoryCategory::where('id', $catVal)->where('status', 1)->first();

                if(!empty($catDetails->title)) {
                    $displayCategoryName .= $catDetails->title.', ';
                }
            }
            $displayCategoryName = substr($displayCategoryName, 0, -2);
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}

if(!function_exists('in_array_r')) {
    function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }
}

if(!function_exists('resources_cat2')) {
    function resources_cat2($cat1_id) {
        $resp = [];
        $cat2 = \DB::table('sub_categories')->select('id', 'title')->where('status', 1)->where('category_id', $cat1_id)->orderby('title')->get()->toArray();

        foreach($cat2 as $cat2Key => $cat2Value) {
            $resp[] = [
                'id' => $cat2Value->id,
                'title' => $cat2Value->title,
                'cat_level_3' => resources_cat3($cat2Value->id)
            ];
        }

        return $resp;
    }
}

if(!function_exists('resources_cat3')) {
    function resources_cat3($cat2_id) {
        $resp = [];
        $cat3 = \DB::table('sub_category_levels')->select('id', 'title')->where('status', 1)->where('sub_category_id', $cat2_id)->orderby('title')->get()->toArray();

        foreach($cat3 as $cat3Key => $cat3Value) {
            $resp[] = [
                'id' => $cat3Value->id,
                'title' => $cat3Value->title
            ];
        }

        return $resp;
    }
    // send mail helper
    function SendMail($data)
    {
        // mail log
        $newMail = new MailLog();
        $newMail->from = 'onenesstechsolution@gmail.com';
        $newMail->to = $data['email'];
        $newMail->subject = $data['subject'];
        $newMail->blade_file = $data['blade_file'];
        $newMail->payload = json_encode($data);
        $newMail->save();

        // send mail
        Mail::send($data['blade_file'], $data, function ($message) use ($data) {
            $message->to($data['email'])->subject($data['subject'])->from('onenesstechsolution@gmail.com', env('APP_NAME'));
        });
    }
}

if(!function_exists('seoManagement')) {
    function seoManagement($pagename) {
        $seoDetail = \DB::table('seo_management')->where('page', '=', $pagename)->first();

        if(!empty($seoDetail)) {
            return $seoDetail;
        } else {
            return false;
        }
    } 
}

if(!function_exists('directoryAddressBreakup')) {
    function directoryAddressBreakup($address) {
        $addressArr = explode(', ', $address);
        return $addressArr;
    }
}

if(!function_exists('directoryAddressBreakupType2')) {
    function directoryAddressBreakupType2($address) {
        $addressArr = explode(',', $address);
        return $addressArr;
    }
}


if (!function_exists('slugGenerate')) {
    function slugGenerate($title, $table) {
        $slug = Str::slug($title, '-');
        $slugExistCount = DB::table($table)->where('title', $title)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
        return $slug;
    }
}

// using this for jobs table mainly
if (!function_exists('slugGenerateUPDATED')) {
    function slugGenerateUPDATED($title, $table) {
        $slug = Str::slug($title, '-');
        $slugExistCount = DB::table($table)->where('title', $title)->count();
        // if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
        if ($slugExistCount > 0) $number = ($slugExistCount + 1);
        
        // slug check
        $slugExistCount2 = DB::table($table)->where('slug', $slug)->count();
        // if ($slugExistCount2 > 0) $slug = $slug . '-' . ($slugExistCount2 + 1);
        if ($slugExistCount2 > 0) $number = ($number + 1);

        $slug = $slug.'-'.$number;

        return $slug;
    }
}

//event-business
if(!function_exists('eventBusiness')) {
    function eventBusiness($directory_id) {
        
        if(!empty($directory_id)) {
             $displayCategoryName = '';
             foreach(explode(',', $directory_id) as $catKey => $catVal) {
                 $catDetails = DB::table('directories')->where('id', $catVal)->first();
                if($catDetails !=''){
                 $displayCategoryName .= $catDetails->name.' , ';
                 //dd($displayCategoryName);
                 }
             }

            $displayCategoryName = substr($displayCategoryName, 0, -2);
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}
//deal-business
if(!function_exists('dealBusiness')) {
    function dealBusiness($diectory_id) {
        
        if(!empty($diectory_id)) {
             $displayCategoryName = '';
             foreach(explode(',', $diectory_id) as $catKey => $catVal) {
                 $catDetails = DB::table('directories')->where('id', $catVal)->first();
                if($catDetails !=''){
                 $displayCategoryName .= $catDetails->name.' , ';
                 //dd($displayCategoryName);
                 }
             }

            $displayCategoryName = substr($displayCategoryName, 0, -2);
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}
//deal business details

if(!function_exists('dealBusinessDetails')) {
    function dealBusinessDetails($directory_id) {
        //dd($diectory_id);
        if(!empty($directory_id)) {
             $catDetails = '';
             foreach(explode(',', $directory_id) as $catKey => $catVal) {
                 $catDetails = DB::table('directories')->where('id', $catVal)->get();
                // if($catDetails !=''){
                //  $displayCategoryName .= $catDetails;
                //dd($catDetails);
                //  }
             }

            //$displayCategoryName = substr($displayCategoryName, 0, -2);
            return $catDetails;
        } else {
            return false;
        }
    }
}
//event-category
if(!function_exists('eventCategory')) {
    function eventCategory($category_id) {
        
        if(!empty($category_id)) {
             $displayCategoryName = '';
             foreach(explode(',', $category_id) as $catKey => $catVal) {
                 $catDetails = DB::table('directory_categories')->where('id', $catVal)->first();
                if($catDetails !=''){
                 $displayCategoryName .= $catDetails->parent_category.' , ';
                 //dd($displayCategoryName);
                 }
             }

            $displayCategoryName = substr($displayCategoryName, 0, -2);
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}
//event-business-details
if(!function_exists('eventBusinessDetails')) {
    function eventBusinessDetails($directory_id) {
        if(!empty($directory_id)) {
             $sep_tag= explode(',', $directory_id);
             //dd($sep_tag);
             $displayCategoryName = '';
             foreach($sep_tag as $catKey => $catVal) {
                 $catDetails = DB::table('directories')->where('id', $catVal)->get();
                 //dd($catDetails);
                if($catDetails !=''){
                 $displayCategoryName = $catDetails;
                 //dd($displayCategoryName);
                 }
             }
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}
//deal-category
if(!function_exists('dealCategory')) {
    function dealCategory($category_id) {
        
        if(!empty($category_id)) {
             $displayCategoryName = '';
             foreach(explode(',', $category_id) as $catKey => $catVal) {
                 $catDetails = DB::table('directory_categories')->where('id', $catVal)->first();
                if($catDetails !=''){
                 $displayCategoryName .= $catDetails->parent_category.' , ';
                 //dd($displayCategoryName);
                 }
             }

            $displayCategoryName = substr($displayCategoryName, 0, -2);
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}

if(!function_exists('dealCategoryimage')) {
    function dealCategoryimage($category_id) {
        
        if(!empty($category_id)) {
             $displayCategoryName = '';
             foreach(explode(',', $category_id) as $catKey => $catVal) {
                 $catDetails = DB::table('directory_categories')->where('id', $catVal)->first();
                if($catDetails !=''){
                 $displayCategoryName .= $catDetails->parent_category_image.' , ';
                 //dd($displayCategoryName);
                 }
             }

            $displayCategoryName = substr($displayCategoryName, 0, -2);
            return $displayCategoryName;
        } else {
            return false;
        }
    }
}

//review user name concat
if(!function_exists('dealreviewUserName')) {
    function dealreviewUserName($review) {
        
        $name = explode(" ", $review );
        $acronym = "";

        foreach ($name as $w) {
          $acronym .= mb_substr($w, 0, 1);
        }
        if(!empty($acronym)) {
            return $acronym;
        } else {
            return false;
        }
    }
}

//total ratings of deal
function getReviewDetails($deal_id)
{
    $all_review = DealReview::where('deal_id',$deal_id);
    
    $data = [];
    $data['total_reviews'] = $all_review->count();
    $data['total_person_reviewed'] = $all_review->groupBy('user_id')->get()->count();
    $data['average_star_count'] = $all_review->avg('rating');
    return $data;
}

//deal rating html
if(!function_exists('dealRatingHtml')) {
    function dealRatingHtml($rating = null) {
        if ($rating == 0) {
            $resp = '<p>No ratings available</p>';
        } elseif ($rating == 1) {
            $resp = '
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
            </div>
';
        } elseif ($rating > 1 && $rating < 2) {
            $resp = '
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
            </div>
            ';
        } elseif ($rating == 2) {
            $resp = '
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
            </div>
            ';
        } elseif ($rating > 2 && $rating < 3) {
            $resp = '
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
            </div>
            ';
        } elseif ($rating == 3) {
            $resp = '
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
            </div>
            ';
        } elseif ($rating > 3 && $rating < 4) {
            $resp = '
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <i class="far fa-star"></i>
            </div>
            ';
        } elseif ($rating == 4) {
            $resp = '
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
            </div>
            ';
        } elseif ($rating > 4 && $rating < 5) {
            $resp = '
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            ';
        } else {
            $resp = '
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            ';
        }

        return $resp;
    }
}
//related events

//job skill
if(!function_exists('jobSkill')){
    function jobSkill($skill) {
        if(!empty($skill)) {
            foreach (explode('||',$skill) as $item)
            {
                if(!empty($item)) {
                return $item;
                } else {
                    return false;
                }
            }
        }
    }  
}
//job Responsibilities
if(!function_exists('jobResponsibility')){
    function jobResponsibility($responsibility) {
        if(!empty($responsibility)) {
            foreach (explode('||',$responsibility) as $item)
            {
                if(!empty($item)) {
                return $item;
                } else {
                    return false;
                }
            }
        }
    }  
}
//Benefits & Perks
if(!function_exists('jobBenifits')){
    function jobBenifits($benifits) {
        if(!empty($benifits)) {
            foreach (explode('||',$benifits) as $item)
            {
                if(!empty($item)) {
                return $item;
                } else {
                    return false;
                }
            }
        }
    }  
}

if(!function_exists('activityStore')) {
    function activityStore($data) {
        $activity = new Activity;
        $activity->user_id = $data['user_id'];
        $activity->user_type = $data['user_type'];
        $activity->date = $data['date'];
        $activity->time = $data['time'];
        $activity->type = $data['type'];
        $activity->location = $data['location'];
        $activity->save();
    }
}


//review like count
function CountLikeReview($reviewId){
    $vote=ReviewVote::where('review_id',$reviewId)->where('vote_status',1)->count();
    if(($vote)>0)
    return $vote;
}


//review like count
function CountDisLikeReview($reviewId){
    $vote=ReviewVote::where('review_id',$reviewId)->where('vote_status',0)->count();
    if(($vote)>0)
    return $vote;
}