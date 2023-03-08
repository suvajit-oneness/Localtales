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

		// 2FA toggle
		Route::post('/twoFacAuth/toggle', 'Business\UserController@twoFacAuthToggle')->name('business.twoFacAuth.toggle');

		// review
	    Route::get('/review', 'Business\ReviewController@index')->name('business.review');
	    Route::get('/review/{id}', 'Business\ReviewController@detail')->name('business.review.detail');

		// notification
		Route::get('/notification', 'Business\NotificationController@index')->name('business.notification.index');
		Route::post('/notification/read', 'Business\NotificationController@read')->name('business.notification.read');
		Route::get('/notification/setup', 'Business\NotificationController@setup')->name('business.notification.setup');
		Route::post('/notification/toggle', 'Business\NotificationController@toggle')->name('business.notification.toggle');
		Route::post('/notification/receive/toggle', 'Business\NotificationController@NotificationReceiveType')->name('business.notification.receive.toggle');
		Route::get('/notification/marl/all/read', 'Business\NotificationController@markAllRead')->name('business.notification.mark-all-read');

		// push notification
		Route::get('/push/notification', 'Business\NotificationController@checkPushNotification')->name('business.push.notification.check');
		Route::post('/push/notification/read', 'Business\NotificationController@readPushNotification')->name('business.push.notification.read');

		// deals status check for notification
		Route::get('/deal/status/start', 'Business\DealController@startStatus')->name('business.deal.start.status');
		Route::get('/deal/status/end', 'Business\DealController@endStatus')->name('business.deal.end.status');
		Route::get('/deal/status/after/end', 'Business\DealController@afterEndStatus')->name('business.deal.after.end.status');

		// events status check for notification
		Route::get('/event/status/start', 'Business\EventController@startStatus')->name('business.event.start.status');
		Route::get('/event/status/end', 'Business\EventController@endStatus')->name('business.event.end.status');
		Route::get('/event/status/after/end', 'Business\EventController@afterEndStatus')->name('business.event.after.end.status');

		// business visit count
		Route::get('/visit/count', 'Business\VisitController@index')->name('business.visit.count');

		// postcode details find
		Route::post('/postcode/detail', 'Business\PostcodeController@detail')->name('business.postcode.detail');

		// account delete
		Route::get('/account/delete', 'Business\UserController@accountDelete')->name('business.account.delete');




		Route::get('2fa', 'Business\TwoFAController@index')->name('2fa.index');
		Route::post('2fa', 'Business\TwoFAController@store')->name('2fa.post');
		Route::get('2fa/reset', 'Business\TwoFAController@resend')->name('2fa.resend');
		Route::get('/profile', function () {
			return view('business.auth.edit_profile');
		})->name('business.profile');
		Route::post('/profile/update','Business\UserController@profilestore')->name('business.profile.update');
		Route::get('/change/password', 'Business\UserController@changePassword')->name('business.change.password');
		Route::post('/update/password', 'Business\UserController@updatePassword')->name('business.updatePassword');
		Route::post('/category/search', 'Business\UserController@searchCat')->name('business.category.search');
		Route::post('/category/store', 'Business\UserController@storeCat')->name('business.category.store');
		Route::get('/{dirId}/category/{catId}/delete', 'Business\UserController@deleteCat')->name('business.category.delete');

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

		Route::group(['prefix' => 'deals'], function() {
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
