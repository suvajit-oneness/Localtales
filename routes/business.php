<?php
Route::group(['prefix' => 'business'], function () {
	Route::get('login', 'Business\LoginController@showLoginForm')->name('business.login');
    Route::post('login/check', 'Business\LoginController@login')->name('business.login.post');
	Route::get('/signup', 'Business\SignupController@businesssignup')->name('business.signup');
	Route::get('/signup/{slug}', 'Business\SignupController@businessform')->name('business.form');
	Route::get('/registration', 'Business\SignupController@registrationform')->name('business.details');
	//Route::get('/thankyou', 'Front\IndexController@thankyou')->name('thankyou');
	Route::post('/create', 'Business\SignupController@businessstore')->name('business.store');
	Route::post('/registration/form', 'Business\SignupController@store')->name('business.registration.store');
	Route::post('/signup-page/create', 'Business\SignupController@pagestore')->name('business.signuppage.store');
	Route::get('/thank-you', 'Business\SignupController@createStepThree')->name('products.create.step.three');
	Route::post('directory/create-step-three', 'Business\SignupController@postCreateStepThree')->name('products.create.step.three.post');
	Route::post('/form/{slug}', 'Business\SignupController@businessformUpdate')->name('business.form.update');
	Route::get('logout', 'Business\LoginController@logout')->name('business.logout');

	Route::group(['middleware' => ['auth:business']], function () {
		Route::get('/', function () {
	      	return view('business.dashboard.index');
	    })->name('business.dashboard');
     
	    Route::group(['prefix'  =>   'event'], function() {
			Route::get('/', 'Business\EventController@index')->name('business.event.index');
			Route::get('/create', 'Business\EventController@create')->name('business.event.create');
			Route::post('/store', 'Business\EventController@store')->name('business.event.store');
			Route::get('/{id}/edit', 'Business\EventController@edit')->name('business.event.edit');
			Route::post('/update', 'Business\EventController@update')->name('business.event.update');
			Route::get('/{id}/delete', 'Business\EventController@delete')->name('business.event.delete');
			Route::get('/{id}/details', 'Business\EventController@details')->name('business.event.details');
			Route::post('updateStatus', 'Business\EventController@updateStatus')->name('business.event.updateStatus');
		});

		Route::group(['prefix'  =>   'deal'], function() {
			Route::get('/', 'Business\DealController@index')->name('business.deal.index');
			Route::get('/create', 'Business\DealController@create')->name('business.deal.create');
			Route::post('/store', 'Business\DealController@store')->name('business.deal.store');
			Route::get('/{id}/edit', 'Business\DealController@edit')->name('business.deal.edit');
			Route::post('/update', 'Business\DealController@update')->name('business.deal.update');
			Route::get('/{id}/delete', 'Business\DealController@delete')->name('business.deal.delete');
			Route::get('/{id}/details', 'Business\DealController@details')->name('business.deal.details');
			Route::post('updateStatus', 'Business\DealController@updateStatus')->name('business.deal.updateStatus');
		});
	});
});


//business
//business edit profile
Route::get('/business/profile', function () {
    return view('business.auth.edit_profile');
})->name('business.profile');
Route::post('business/profile/update','Site\BusinessController@profilestore')->name('business.profile.update');
Route::get('business/change/password', 'Site\BusinessController@changePassword')->name('business.change.password');
Route::post('update/password', 'Site\BusinessController@updatePassword')->name('business.updatePassword');
Route::get('business/review', 'Site\BusinessController@review')->name('business.review');
Route::get('/business/{dirId}/category/{catId}/delete', 'Site\BusinessController@deleteCat')->name('business.directory.category.delete');
?>
