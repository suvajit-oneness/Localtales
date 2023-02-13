<?php 
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