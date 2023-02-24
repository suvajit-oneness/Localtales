<?php

Route::post('/postcode', 'Api\PostcodeController@index')->name('user.postcode');
Route::post('/collection/save/toggle', 'Api\CollectionController@save')->name('user.collection.save.toggle');

//blog category wise subcategory
Route::post('/primarycategory/subcategory', 'Api\ApiController@index')->name('user.category');
Route::get('subcategory/{categoryId}', 'Api\ApiController@categorywiseSubcategory');
//subcategory wise tertiary category
Route::get('tertiarycategory/{subcategoryId}', 'Api\ApiController@subcategorywiseTertiarycategory');
//postcode wise suburb
Route::get('postcode-suburb/{postcode}', 'Api\ApiController@postcodewiseSuburb');
//state wise postcode
Route::get('state/postcode/{postcode}', 'Api\ApiController@statewisePostcode');
//postcode-category-search
Route::post('postcode/category', 'Api\ApiController@Postcodecategory')->name('postcode.category');

Route::post('login', 'Api\AuthController@authenticate');
Route::post('register', 'Api\AuthController@register');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'Api\AuthController@getAuthenticatedUser');
    Route::post('profile/update', 'Api\AuthController@updateProfile');

    Route::get('categories', 'Api\ApiController@getCategories');
    Route::post('home/data', 'Api\ApiController@getAllHomeData');
    Route::get('saved/data/{id}', 'Api\ApiController@getUserSavedData');

    Route::group(['prefix'  =>   'deals'], function() {
		Route::get('list', 'Api\DealController@index');
	    Route::get('details/{id}', 'Api\DealController@details');
	    Route::post('filter', 'Api\DealController@filter');
	    Route::post('category-wise', 'Api\DealController@categoryWiseDeals');
	    Route::post('user/save', 'Api\DealController@saveUserDeal');
	    Route::post('user/delete', 'Api\DealController@deleteUserDeal');
	    Route::post('user/check', 'Api\DealController@checkUserDeals');
	});

	Route::group(['prefix'  =>   'events'], function() {
		Route::get('list', 'Api\EventController@index');
	    Route::get('details/{id}', 'Api\EventController@details');
	    Route::post('filter', 'Api\EventController@filter');
	    Route::post('category-wise', 'Api\EventController@categoryWiseDeals');
	    Route::post('user/save', 'Api\EventController@saveUserEvent');
	    Route::post('user/delete', 'Api\EventController@deleteUserEvent');
	    Route::post('user/check', 'Api\EventController@checkUserEvents');
	});

	Route::group(['prefix'  =>   'loop'], function() {
		Route::get('list', 'Api\LoopController@index');
	    Route::get('details/{id}', 'Api\LoopController@details');
	    Route::post('create', 'Api\LoopController@create');
	    Route::post('update', 'Api\LoopController@update');
	    Route::get('user/{id}', 'Api\LoopController@userLoops');
	    Route::get('delete/{id}', 'Api\LoopController@delete');
	    Route::get('comments/{id}', 'Api\LoopController@comments');
	    Route::post('comments/create', 'Api\LoopController@createComment');
	    Route::get('comments/delete/{id}', 'Api\LoopController@deleteComment');
	    Route::post('like', 'Api\LoopController@likeLoop');
	});

	Route::get('notifications', 'Api\ApiController@notifications');

	Route::group(['prefix'  =>   'directories'], function() {
		Route::get('list', 'Api\BusinessController@index');
	    Route::get('details/{id}', 'Api\BusinessController@details');
	    Route::post('category-wise', 'Api\BusinessController@categoryWiseBusiness');
	    Route::post('user/save', 'Api\BusinessController@saveUserBusiness');
	    Route::post('user/delete', 'Api\BusinessController@deleteUserBusiness');
	    Route::post('user/check', 'Api\BusinessController@checkUserBusinesses');
	});
});
Route::post('/business/category/store', 'Site\BusinessController@storeCat')->name('business.directory.category.store');
