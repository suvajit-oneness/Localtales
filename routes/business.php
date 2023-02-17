<?php
Route::group(['prefix' => 'business'], function () {
	Route::get('login', 'Business\LoginController@login')->name('business.login');
    Route::post('login/check', 'Business\LoginController@check')->name('business.login.check');
	Route::get('/signup', 'Business\SignupController@register')->name('business.register');
	Route::post('/register/store', 'Business\SignupController@store')->name('business.register.store');
	Route::get('/thank-you', 'Business\SignupController@thankyou')->name('thank.you');
    /* New Added Routes */
		Route::get('account/verify/{token}', 'Business\SignupController@verifyAccount')->name('user.verify'); 
	//signup for individual business
	Route::get('/signup/{slug}', 'Business\SignupController@view')->name('business.form');
	Route::post('/signup/update/{slug}', 'Business\SignupController@update')->name('business.form.update');


	//registration form for council business
	Route::get('/registration/form', 'Business\SignupController@registrationform')->name('business.details');
	Route::post('/registration/form/store', 'Business\SignupController@registrationformstore')->name('business.registration.store');

	Route::get('logout', 'Business\LoginController@logout')->name('business.logout');

	Route::group(['middleware' => ['auth:business']], function () {
		Route::get('/', function () {
	      	return view('business.dashboard.index');
	    })->name('business.dashboard')->middleware(['auth', 'is_verify_email']);
		Route::get('2fa', 'Business\TwoFAController@index')->name('2fa.index');
		Route::post('2fa', 'Business\TwoFAController@store')->name('2fa.post');
		Route::get('2fa/reset', 'Business\TwoFAController@resend')->name('2fa.resend');
		Route::get('/profile', function () {
			return view('business.auth.edit_profile');
		})->name('business.profile');
		Route::post('/profile/update','Business\UserController@profilestore')->name('business.profile.update');
		Route::get('/change/password', 'Business\UserController@changePassword')->name('business.change.password');
		Route::post('/update/password', 'Business\UserController@updatePassword')->name('business.updatePassword');
	    Route::get('/review', 'Business\UserController@review')->name('business.review');
		Route::post('/category/search', 'Business\UserController@searchCat')->name('business.category.search');
		Route::post('/category/store', 'Business\UserController@storeCat')->name('business.category.store');
		Route::get('/{dirId}/category/{catId}/delete', 'Business\UserController@deleteCat')->name('business.category.delete');
		 // notification
		 Route::get('/notification/setup', 'Business\NotificationController@setup')->name('business.notification.setup');
		 Route::post('/notification/toggle', 'Business\NotificationController@toggle')->name('business.notification.toggle');
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

?>
