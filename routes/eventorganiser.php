<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\EventOrganiser;
Route::group(['prefix' => 'eventorganiser'], function () {
   
	Route::group(['middleware' => ['auth:eventorganiser']], function () {
		Route::get('/dashboard', function () {
	      	return view('eventorganiser.dashboard.index');
	    })->name('eventorganiser.dashboard');
        Route::get('/profile', function () {
            return view('eventorganiser.auth.edit_profile');
        })->name('eventorganiser.profile');
        //Route::get('/profile', 'EventOrganiser\LoginController@index')->name('eventorganiser.profile');
        //Route::post('/profile', 'EventOrganiser\LoginController@update')->name('eventorganiser.profile.update');
        Route::get('/change/password', function () {
            return view('eventorganiser.changePassword');
        })->middleware('auth:eventorganiser')->name('eventorganiser.change.password');
        
        //Route::post('event-organiser/profile/update','Site\BusinessController@eventorganiserprofilestore')->name('event-organiser-dashboard.profile.update');

        
        //event
    Route::group(['prefix' => '/event'], function () {
    Route::get('/', 'EventOrganiser\EventController@index')->name('eventorganiser.event.index');
    Route::get('/create', 'EventOrganiser\EventController@create')->name('eventorganiser.event.create');
    Route::post('/store', 'EventOrganiser\EventController@store')->name('eventorganiser.event.store');
    Route::get('/{id}/edit', 'EventOrganiser\EventController@edit')->name('eventorganiser.event.edit');
    Route::post('/update', 'EventOrganiser\EventController@update')->name('eventorganiser.event.update');
    Route::get('/{id}/delete', 'EventOrganiser\EventController@delete')->name('eventorganiser.event.delete');
    Route::post('updateStatus', 'EventOrganiser\EventController@updateStatus')->name('eventorganiser.event.updateStatus');
    Route::get('/{id}/details', 'EventOrganiser\EventController@details')->name('eventorganiser.event.details');
});

    });
});
       // profile management
        //Route::post('update-profile', 'Business\LoginController@updateProfile')->name('business.dashboard.updateProfile');
	    //Route::post('/profile/update/new','EventOrganiser\LoginController@profilestore')->name('eventorganiser.profile.update');
      //event organiser
      Route::post('eventorganiser/update/password', 'EventOrganiser\ProfileController@updatePassword')->name('updatePassword');
      Route::post('event-organiser/profile/update', 'EventOrganiser\ProfileController@updateProfile')->middleware('auth:eventorganiser')->name('event-organiser-dashboard.profile.update');
    
?>
