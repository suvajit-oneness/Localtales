<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
    Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');

    //admin password reset routes
    Route::post('/password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset', 'Admin\ResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');

    Route::get('/register', 'Admin\RegisterController@showRegistrationForm')->name('admin.register')->middleware('hasInvitation');
    Route::post('/register', 'Admin\RegisterController@register')->name('admin.register.post');

    Route::group(['middleware' => ['auth:admin']], function () {


        Route::get('/dashboard', 'Admin\ProfileController@dashboard')->name('admin.dashboard');
        Route::get('/invite_list', 'Admin\InvitationController@index')->name('admin.invite');
        Route::get('/invitation', 'Admin\InvitationController@create')->name('admin.invite.create');
        Route::post('/invitation', 'Admin\InvitationController@store')->name('admin.invitation.store');
        Route::get('/adminuser', 'Admin\AdminUserController@index')->name('admin.adminuser');
        Route::post('/adminuser', 'Admin\AdminUserController@updateAdminUser')->name('admin.adminuser.update');
        Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings');
        Route::post('/settings', 'Admin\SettingController@update')->name('admin.settings.update');

        Route::get('/profile', 'Admin\ProfileController@index')->name('admin.profile');
        Route::post('/profile', 'Admin\ProfileController@update')->name('admin.profile.update');
        Route::post('/changepassword', 'Admin\ProfileController@changePassword')->name('admin.profile.changepassword');

        /**  user management      **/
        Route::group(['prefix'  =>   'users'], function () {
            Route::get('/', 'Admin\UserManagementController@index')->name('admin.users.index');
            Route::post('/', 'Admin\UserManagementController@updateUser')->name('admin.users.post');
            Route::get('/{id}/delete', 'Admin\UserManagementController@delete')->name('admin.users.delete');
            Route::get('/{id}/view', 'Admin\UserManagementController@viewDetail')->name('admin.users.detail');
            Route::post('updateStatus', 'Admin\UserManagementController@updateStatus')->name('admin.users.updateStatus');
            Route::get('/{id}/details', 'Admin\UserManagementController@details')->name('admin.users.details');
        });

        //**  State management  **//
        Route::group(['prefix'  =>   'state'], function () {


            Route::get('/', 'Admin\StateManagementController@index')->name('admin.state.index');
            Route::get('/create', 'Admin\StateManagementController@create')->name('admin.state.create');
            Route::post('/store', 'Admin\StateManagementController@store')->name('admin.state.store');
            Route::get('/{id}/edit', 'Admin\StateManagementController@edit')->name('admin.state.edit');
            Route::post('/update', 'Admin\StateManagementController@update')->name('admin.state.update');
            Route::get('/{id}/delete', 'Admin\StateManagementController@delete')->name('admin.state.delete');
            Route::post('updateStatus', 'Admin\StateManagementController@updateStatus')->name('admin.state.updateStatus');
            Route::get('/{id}/details', 'Admin\StateManagementController@details')->name('admin.state.details');
            Route::post('/csv-store', 'Admin\StateManagementController@csvStore')->name('admin.state.data.csv.store');
            Route::get('/export', 'Admin\StateManagementController@export')->name('admin.state.data.csv.export');
            Route::post('upload/image', 'Admin\StateManagementController@upload_bulk_images')->name('admin.state.image.upload');
        });
        //**  Pin code management   **/
        Route::group(['prefix'  =>   'pin'], function () {
            Route::get('/', 'Admin\PinCodeManagementController@index')->name('admin.pin.index');
            Route::get('/create', 'Admin\PinCodeManagementController@create')->name('admin.pin.create');
            Route::post('/store', 'Admin\PinCodeManagementController@store')->name('admin.pin.store');
            Route::get('/{id}/edit', 'Admin\PinCodeManagementController@edit')->name('admin.pin.edit');
            Route::post('/update', 'Admin\PinCodeManagementController@update')->name('admin.pin.update');
            Route::get('/{id}/delete', 'Admin\PinCodeManagementController@delete')->name('admin.pin.delete');
            Route::post('updateStatus', 'Admin\PinCodeManagementController@updateStatus')->name('admin.pin.updateStatus');
            Route::get('/{id}/details', 'Admin\PinCodeManagementController@details')->name('admin.pin.details');
            Route::post('/csv-store', 'Admin\PinCodeManagementController@csvStore')->name('admin.pincode.data.csv.store');
            Route::get('/export', 'Admin\PinCodeManagementController@export')->name('admin.pin.data.csv.export');
            Route::post('upload/image', 'Admin\PinCodeManagementController@upload_bulk_images')->name('admin.pin.image.upload');
        });
        //**  Suburb management   **/


        Route::group(['prefix'  =>   'suburb'], function () {

            Route::get('/', 'Admin\SuburbManagementController@index')->name('admin.suburb.index');
            Route::get('/create', 'Admin\SuburbManagementController@create')->name('admin.suburb.create');
            Route::post('/store', 'Admin\SuburbManagementController@store')->name('admin.suburb.store');
            Route::get('/{id}/edit', 'Admin\SuburbManagementController@edit')->name('admin.suburb.edit');
            Route::post('/update', 'Admin\SuburbManagementController@update')->name('admin.suburb.update');
            Route::get('/{id}/delete', 'Admin\SuburbManagementController@delete')->name('admin.suburb.delete');
            Route::post('updateStatus', 'Admin\SuburbManagementController@updateStatus')->name('admin.suburb.updateStatus');
            Route::get('/{id}/details', 'Admin\SuburbManagementController@details')->name('admin.suburb.details');
            Route::post('/csv-store', 'Admin\SuburbManagementController@csvStore')->name('admin.suburb.data.csv.store');
            Route::get('/export', 'Admin\SuburbManagementController@export')->name('admin.suburb.data.csv.export');
            Route::post('upload/image', 'Admin\SuburbManagementController@upload_bulk_images')->name('admin.suburb.image.upload');
        });
        //**  Category management   **/
        Route::group(['prefix'  =>   'category'], function () {
            Route::get('/', 'Admin\CategoryManagementController@index')->name('admin.category.index');
            Route::get('/create', 'Admin\CategoryManagementController@create')->name('admin.category.create');
            Route::post('/store', 'Admin\CategoryManagementController@store')->name('admin.category.store');
            Route::get('/{id}/edit', 'Admin\CategoryManagementController@edit')->name('admin.category.edit');
            Route::post('/update', 'Admin\CategoryManagementController@update')->name('admin.category.update');
            Route::get('/{id}/delete', 'Admin\CategoryManagementController@delete')->name('admin.category.delete');
            Route::post('updateStatus', 'Admin\CategoryManagementController@updateStatus')->name('admin.category.updateStatus');
            Route::get('/{id}/details', 'Admin\CategoryManagementController@details')->name('admin.category.details');
            Route::post('/csv-store', 'Admin\CategoryManagementController@csvStore')->name('admin.category.data.csv.store');
            Route::get('/export', 'Admin\CategoryManagementController@export')->name('admin.category.data.csv.export');
        });

        //faq

        Route::group(['prefix'  =>   'categoryfaq'], function () {
            Route::get('/', 'Admin\CategoryFaqManagementController@index')->name('admin.categoryfaq.index');
            Route::get('/create', 'Admin\CategoryFaqManagementController@create')->name('admin.categoryfaq.create');
            Route::post('/store', 'Admin\CategoryFaqManagementController@store')->name('admin.categoryfaq.store');
            Route::get('/{id}/edit', 'Admin\CategoryFaqManagementController@edit')->name('admin.categoryfaq.edit');
            Route::post('/update', 'Admin\CategoryFaqManagementController@update')->name('admin.categoryfaq.update');
            Route::get('/{id}/delete', 'Admin\CategoryFaqManagementController@delete')->name('admin.categoryfaq.delete');
            Route::post('updateStatus', 'Admin\CategoryFaqManagementController@updateStatus')->name('admin.categoryfaq.updateStatus');
            Route::get('/{id}/details', 'Admin\CategoryFaqManagementController@details')->name('admin.categoryfaq.details');
            Route::post('/csv-store', 'Admin\CategoryFaqManagementController@csvStore')->name('admin.categoryfaq.data.csv.store');
        });
        //**  Sub category management  **/
        Route::group(['prefix'  =>   'subcategory'], function () {



            Route::get('/', 'Admin\SubCategoryManagementController@index')->name('admin.subcategory.index');
            Route::get('/create', 'Admin\SubCategoryManagementController@create')->name('admin.subcategory.create');
            Route::post('/store', 'Admin\SubCategoryManagementController@store')->name('admin.subcategory.store');
            Route::get('/{id}/edit', 'Admin\SubCategoryManagementController@edit')->name('admin.subcategory.edit');
            Route::post('/update', 'Admin\SubCategoryManagementController@update')->name('admin.subcategory.update');
            Route::get('/{id}/delete', 'Admin\SubCategoryManagementController@delete')->name('admin.subcategory.delete');
            Route::post('updateStatus', 'Admin\SubCategoryManagementController@updateStatus')->name('admin.subcategory.updateStatus');
            Route::get('/{id}/details', 'Admin\SubCategoryManagementController@details')->name('admin.subcategory.details');
            Route::post('/csv-store', 'Admin\SubCategoryManagementController@csvStore')->name('admin.subcategory.data.csv.store');
            Route::get('/export', 'Admin\SubCategoryManagementController@export')->name('admin.subcategory.data.csv.export');
        });
        //**  Sub category level2 management  **/
        Route::group(['prefix'  =>   'sub-category-level2'], function () {
            Route::get('/', 'Admin\SubCategoryLevelController@index')->name('admin.sub-category-level2.index');
            Route::get('/create', 'Admin\SubCategoryLevelController@create')->name('admin.sub-category-level2.create');
            Route::post('/store', 'Admin\SubCategoryLevelController@store')->name('admin.sub-category-level2.store');
            Route::get('/{id}/edit', 'Admin\SubCategoryLevelController@edit')->name('admin.sub-category-level2.edit');
            Route::post('/update', 'Admin\SubCategoryLevelController@update')->name('admin.sub-category-level2.update');
            Route::get('/{id}/delete', 'Admin\SubCategoryLevelController@delete')->name('admin.sub-category-level2.delete');
            Route::post('updateStatus', 'Admin\SubCategoryLevelController@updateStatus')->name('admin.sub-category-level2.updateStatus');
            Route::get('/{id}/details', 'Admin\SubCategoryLevelController@details')->name('admin.sub-category-level2.details');
            Route::post('/csv-store', 'Admin\SubCategoryLevelController@csvStore')->name('admin.sub-category-level2.data.csv.store');
            Route::get('/export', 'Admin\SubCategoryLevelController@export')->name('admin.sub-category-level2.data.csv.export');
        });


        //**  blog management  **/
        Route::group(['prefix'  =>   'blog'], function () {
            Route::get('/', 'Admin\BlogController@index')->name('admin.blog.index');
            Route::get('/create', 'Admin\BlogController@create')->name('admin.blog.create');
            Route::post('/store', 'Admin\BlogController@store')->name('admin.blog.store');
            Route::get('/{id}/edit', 'Admin\BlogController@edit')->name('admin.blog.edit');
            Route::post('/update', 'Admin\BlogController@update')->name('admin.blog.update');
            Route::get('/{id}/delete', 'Admin\BlogController@delete')->name('admin.blog.delete');
            Route::post('updateStatus', 'Admin\BlogController@updateStatus')->name('admin.blog.updateStatus');
            Route::post('blog/updateStatus', 'Admin\BlogController@blogupdateStatus')->name('admin.blogStatus.updateStatus');
            Route::get('/{id}/details', 'Admin\BlogController@details')->name('admin.blog.details');
            Route::post('/csv-store', 'Admin\BlogController@csvStore')->name('admin.blog.data.csv.store');
            Route::get('/export', 'Admin\BlogController@export')->name('admin.blog.data.csv.export');
        });

            //**  blog management  **/
            Route::group(['prefix'  =>   'blogwidget'], function () {


                Route::get('/', 'Admin\BlogWidgetController@index')->name('admin.blogwidget.index');
                Route::get('/create', 'Admin\BlogWidgetController@create')->name('admin.blogwidget.create');
                Route::post('/store', 'Admin\BlogWidgetController@store')->name('admin.blogwidget.store');
                Route::get('/{id}/edit', 'Admin\BlogWidgetController@edit')->name('admin.blogwidget.edit');
                Route::post('/update/{id}', 'Admin\BlogWidgetController@update')->name('admin.blogwidget.update');
                Route::get('/{id}/delete', 'Admin\BlogWidgetController@delete')->name('admin.blogwidget.delete');
                Route::post('updateStatus', 'Admin\BlogWidgetController@updateStatus')->name('admin.blogwidget.updateStatus');
                Route::get('/{id}/details', 'Admin\BlogWidgetController@details')->name('admin.blogwidget.details');
                Route::post('/csv-store', 'Admin\BlogWidgetController@csvStore')->name('admin.blogwidget.data.csv.store');
                Route::get('/export', 'Admin\BlogWidgetController@export')->name('admin.blogwidget.data.csv.export');
            });
            //**  blog management  **/
            Route::group(['prefix'  =>   'blogfeature'], function () {


                Route::get('/', 'Admin\BlogFeatureController@index')->name('admin.blogfeature.index');
                Route::get('/create', 'Admin\BlogFeatureController@create')->name('admin.blogfeature.create');
                Route::post('/store', 'Admin\BlogFeatureController@store')->name('admin.blogfeature.store');
                Route::get('/{id}/edit', 'Admin\BlogFeatureController@edit')->name('admin.blogfeature.edit');
                Route::post('/update/{id}', 'Admin\BlogFeatureController@update')->name('admin.blogfeature.update');
                Route::get('/{id}/delete', 'Admin\BlogFeatureController@delete')->name('admin.blogfeature.delete');
                Route::post('updateStatus', 'Admin\BlogFeatureController@updateStatus')->name('admin.blogfeature.updateStatus');
                Route::get('/{id}/details', 'Admin\BlogFeatureController@details')->name('admin.blogfeature.details');
                Route::post('/csv-store', 'Admin\BlogFeatureController@csvStore')->name('admin.blogfeature.data.csv.store');
                Route::get('/export', 'Admin\BlogFeatureController@export')->name('admin.blogfeature.data.csv.export');
            });
             //**  blog management  **/
             Route::group(['prefix'  =>   'blogfaqcat'], function () {


                Route::get('/', 'Admin\BlogFaqCategoryController@index')->name('admin.blogfaqcat.index');
                Route::get('/create', 'Admin\BlogFaqCategoryController@create')->name('admin.blogfaqcat.create');
                Route::post('/store', 'Admin\BlogFaqCategoryController@store')->name('admin.blogfaqcat.store');
                Route::get('/{id}/edit', 'Admin\BlogFaqCategoryController@edit')->name('admin.blogfaqcat.edit');
                Route::post('/update', 'Admin\BlogFaqCategoryController@update')->name('admin.blogfaqcat.update');
                Route::get('/{id}/delete', 'Admin\BlogFaqCategoryController@delete')->name('admin.blogfaqcat.delete');
                Route::post('updateStatus', 'Admin\BlogFaqCategoryController@updateStatus')->name('admin.blogfaqcat.updateStatus');
                Route::get('/{id}/details', 'Admin\BlogFaqCategoryController@details')->name('admin.blogfaqcat.details');
                Route::post('/csv-store', 'Admin\BlogFaqCategoryController@csvStore')->name('admin.blogfaqcat.data.csv.store');
                Route::get('/export', 'Admin\BlogFaqCategoryController@export')->name('admin.blogfaqcat.data.csv.export');
            });
             //**  blog management  **/
             Route::group(['prefix'  =>   'blogsubcatfaq'], function () {


                Route::get('/', 'Admin\BlogFaqSubCategoryController@index')->name('admin.blogsubcatfaq.index');
                Route::get('/create', 'Admin\BlogFaqSubCategoryController@create')->name('admin.blogsubcatfaq.create');
                Route::post('/store', 'Admin\BlogFaqSubCategoryController@store')->name('admin.blogsubcatfaq.store');
                Route::get('/{id}/edit', 'Admin\BlogFaqSubCategoryController@edit')->name('admin.blogsubcatfaq.edit');
                Route::post('/update', 'Admin\BlogFaqSubCategoryController@update')->name('admin.blogsubcatfaq.update');
                Route::get('/{id}/delete', 'Admin\BlogFaqSubCategoryController@delete')->name('admin.blogsubcatfaq.delete');
                Route::post('updateStatus', 'Admin\BlogFaqSubCategoryController@updateStatus')->name('admin.blogsubcatfaq.updateStatus');
                Route::get('/{id}/details', 'Admin\BlogFaqSubCategoryController@details')->name('admin.blogsubcatfaq.details');
                Route::post('/csv-store', 'Admin\BlogFaqSubCategoryController@csvStore')->name('admin.blogfaq.data.csv.store');
                Route::get('/export', 'Admin\BlogFaqSubCategoryController@export')->name('admin.blogsubcatfaq.data.csv.export');
            });
            //**  blog management  **/
            Route::group(['prefix'  =>   'blogfaq'], function () {


                Route::get('/{id}', 'Admin\BlogFaqController@index')->name('admin.blogfaq.index');
                Route::get('/create', 'Admin\BlogFaqController@create')->name('admin.blogfaq.create');
                Route::post('/store', 'Admin\BlogFaqController@store')->name('admin.blogfaq.store');
                Route::get('/{id}/edit', 'Admin\BlogFaqController@edit')->name('admin.blogfaq.edit');
                Route::post('/update', 'Admin\BlogFaqController@update')->name('admin.blogfaq.update');
                Route::get('/{id}/delete', 'Admin\BlogFaqController@delete')->name('admin.blogfaq.delete');
                Route::post('updateStatus', 'Admin\BlogFaqController@updateStatus')->name('admin.blogfaq.updateStatus');
                Route::get('/{id}/details', 'Admin\BlogFaqController@details')->name('admin.blogfaq.details');
                Route::post('/csv-store', 'Admin\BlogFaqController@csvStore')->name('admin.blogfaq.data.csv.store');
                Route::get('/export', 'Admin\BlogFaqController@export')->name('admin.blogfaq.data.csv.export');
            });

        //**  Directory management  **/
        Route::group(['prefix'  =>   'directory'], function () {
            Route::get('/', 'Admin\DirectoryController@index')->name('admin.directory.index');
            Route::get('/create', 'Admin\DirectoryController@create')->name('admin.directory.create');
            Route::post('/store', 'Admin\DirectoryController@store')->name('admin.directory.store');
            Route::get('/{id}/edit', 'Admin\DirectoryController@edit')->name('admin.directory.edit');
            Route::post('/update', 'Admin\DirectoryController@update')->name('admin.directory.update');
            Route::get('/{id}/delete', 'Admin\DirectoryController@delete')->name('admin.directory.delete');
            Route::post('updateStatus', 'Admin\DirectoryController@updateStatus')->name('admin.directory.updateStatus');
            Route::get('/{id}/details', 'Admin\DirectoryController@details')->name('admin.directory.details');
            Route::post('/csv-store', 'Admin\DirectoryController@csvStore')->name('admin.directory.data.csv.store');
            Route::get('/export', 'Admin\DirectoryController@export')->name('admin.directory.data.csv.export');
            Route::get('/fix', 'Admin\DirectoryController@dataFix')->name('admin.directory.data.fix');
            Route::get('/fix/rating', 'Admin\DirectoryController@dataFixrating')->name('admin.directory.data.fix.rating');
            Route::get('/test', 'Admin\DirectoryController@test');

            Route::get('/{dirId}/category/{catId}/delete', 'Admin\DirectoryController@deleteCat')->name('admin.directory.category.delete');
            Route::post('/category/search', 'Admin\DirectoryController@searchCat')->name('admin.directory.category.search');
            Route::post('/category/store', 'Admin\DirectoryController@storeCat')->name('admin.directory.category.store');

            // google categories
            Route::get('/google/category', 'Admin\DirectoryController@googleCategory')->name('admin.directory.google.category');
            Route::get('/category/match', 'Admin\DirectoryController@categoryMatch')->name('admin.directory.category.match');
            Route::post('/verify', 'Admin\DirectoryController@directoryVerify')->name('admin.directory.verify');
            Route::get('/verify/export', 'Admin\DirectoryController@directoryVerifyExport')->name('admin.directory.verify.export');

            //review
            Route::get('/{id}/review/details', 'Admin\DirectoryController@reviewDetails')->name('admin.directory.review.details');
        });

        //**  Collection management  **/
        Route::group(['prefix'  =>   'collection'], function () {


            Route::get('/', 'Admin\CollectionController@index')->name('admin.collection.index');
            Route::get('/create', 'Admin\CollectionController@create')->name('admin.collection.create');
            Route::post('/store', 'Admin\CollectionController@store')->name('admin.collection.store');
            Route::get('/{id}/edit', 'Admin\CollectionController@edit')->name('admin.collection.edit');
            Route::post('/update', 'Admin\CollectionController@update')->name('admin.collection.update');
            Route::get('/{id}/delete', 'Admin\CollectionController@delete')->name('admin.collection.delete');
            Route::post('updateStatus', 'Admin\CollectionController@updateStatus')->name('admin.collection.updateStatus');
            Route::get('/{id}/details', 'Admin\CollectionController@details')->name('admin.collection.details');
            Route::post('/csv-store', 'Admin\CollectionController@csvStore')->name('admin.collection.data.csv.store');
            Route::get('/export', 'Admin\CollectionController@export')->name('admin.collection.data.csv.export');
            Route::post('upload/image', 'Admin\CollectionController@upload_bulk_images')->name('admin.collection.image.upload');
            Route::get('/{id}/directory-save', 'Admin\CollectionController@directory')->name('admin.collection.directory');
            Route::post('/directory-store', 'Admin\CollectionController@directorystore')->name('admin.collection.directory-save');
        });

        //job management
         
        Route::group(['prefix'  =>   'job'], function () {

            //**  job category  **//
               Route::group(['prefix' => 'category'], function () {
               Route::get('/', 'Admin\JobCategoryController@index')->name('admin.job.category.index');
               Route::get('/create', 'Admin\JobCategoryController@create')->name('admin.job.category.create');
               Route::post('/store', 'Admin\JobCategoryController@store')->name('admin.job.category.store');
               Route::get('/{id}/edit', 'Admin\JobCategoryController@edit')->name('admin.job.category.edit');
               Route::post('/update', 'Admin\JobCategoryController@update')->name('admin.job.category.update');
               Route::get('/{id}/delete', 'Admin\JobCategoryController@delete')->name('admin.job.category.delete');
               Route::post('updateStatus', 'Admin\JobCategoryController@updateStatus')->name('admin.job.category.updateStatus');
               Route::get('/{id}/details', 'Admin\JobCategoryController@details')->name('admin.job.category.details');
               Route::post('/csv-store', 'Admin\JobCategoryController@csvStore')->name('admin.job.category.data.csv.store');
               Route::get('/export', 'Admin\JobCategoryController@export')->name('admin.job.category.data.csv.export');
           });
           //**  employment type  **//
               Route::group(['prefix' => 'employmentType'], function () {
               Route::get('/', 'Admin\JobEmploymentTypeController@index')->name('admin.job.type.index');
               Route::get('/create', 'Admin\JobEmploymentTypeController@create')->name('admin.job.type.create');
               Route::post('/store', 'Admin\JobEmploymentTypeController@store')->name('admin.job.type.store');
               Route::get('/{id}/edit', 'Admin\JobEmploymentTypeController@edit')->name('admin.job.type.edit');
               Route::post('/update', 'Admin\JobEmploymentTypeController@update')->name('admin.job.type.update');
               Route::get('/{id}/delete', 'Admin\JobEmploymentTypeController@delete')->name('admin.job.type.delete');
               Route::post('updateStatus', 'Admin\JobEmploymentTypeController@updateStatus')->name('admin.job.type.updateStatus');
               Route::get('/{id}/details', 'Admin\JobEmploymentTypeController@details')->name('admin.job.type.details');
               Route::post('/csv-store', 'Admin\JobEmploymentTypeController@csvStore')->name('admin.job.type.data.csv.store');
               Route::get('/export', 'Admin\JobEmploymentTypeController@export')->name('admin.job.type.data.csv.export');
           });

           Route::get('/', 'Admin\JobController@index')->name('admin.job.index');
           Route::get('/create', 'Admin\JobController@create')->name('admin.job.create');
           Route::post('/store', 'Admin\JobController@store')->name('admin.job.store');
           Route::get('/{id}/edit', 'Admin\JobController@edit')->name('admin.job.edit');
           Route::post('/update', 'Admin\JobController@update')->name('admin.job.update');
           Route::get('/{id}/delete', 'Admin\JobController@delete')->name('admin.job.delete');
           Route::post('updateStatus', 'Admin\JobController@updateStatus')->name('admin.job.updateStatus');
           Route::get('/{id}/details', 'Admin\JobController@details')->name('admin.job.details');
           Route::post('/csv-store', 'Admin\JobController@csvStore')->name('admin.job.data.csv.store');
           Route::get('/export', 'Admin\JobController@export')->name('admin.job.data.csv.export');
           Route::get('/job/application/{id}', 'Admin\JobController@application')->name('admin.job.application');
           
        });


        //**  Directory-Collection management  **/
        Route::group(['prefix'  =>   'collectiondir'], function () {


            Route::get('/', 'Admin\DirectoryCollectionController@index')->name('admin.collectiondir.index');
            Route::get('/create', 'Admin\DirectoryCollectionController@create')->name('admin.collectiondir.create');
            Route::post('/store', 'Admin\DirectoryCollectionController@store')->name('admin.collectiondir.store');
            Route::get('/{id}/edit', 'Admin\DirectoryCollectionController@edit')->name('admin.collectiondir.edit');
            Route::post('/update', 'Admin\DirectoryCollectionController@update')->name('admin.collectiondir.update');
            Route::get('/{id}/delete', 'Admin\DirectoryCollectionController@delete')->name('admin.collectiondir.delete');
            Route::post('updateStatus', 'Admin\DirectoryCollectionController@updateStatus')->name('admin.collectiondir.updateStatus');
            Route::get('/{id}/details', 'Admin\DirectoryCollectionController@details')->name('admin.collectiondir.details');
            Route::post('/csv-store', 'Admin\DirectoryCollectionController@csvStore')->name('admin.collectiondir.data.csv.store');
            Route::get('/export', 'Admin\DirectoryCollectionController@export')->name('admin.collectiondir.data.csv.export');
        });



        /**  Directory Primary Category  **/
        Route::group(['prefix' => 'dircategory'], function () {
            Route::get('/', 'Admin\DirectoryCategoryController@index')->name('admin.dircategory.index');
            Route::get('/create', 'Admin\DirectoryCategoryController@create')->name('admin.dircategory.create');
            Route::post('/store', 'Admin\DirectoryCategoryController@store')->name('admin.dircategory.store');
            Route::get('/{id}/edit', 'Admin\DirectoryCategoryController@edit')->name('admin.dircategory.edit');
            Route::post('/update', 'Admin\DirectoryCategoryController@update')->name('admin.dircategory.update');
            Route::get('/{id}/delete', 'Admin\DirectoryCategoryController@delete')->name('admin.dircategory.delete');
            Route::post('updateStatus', 'Admin\DirectoryCategoryController@updateStatus')->name('admin.dircategory.updateStatus');
            Route::get('/{id}/details', 'Admin\DirectoryCategoryController@details')->name('admin.dircategory.details');
            Route::get('/{id}/email-template/details', 'Admin\DirectoryCategoryController@emaildetails')->name('admin.dircategory.email.details');
            Route::get('/{id}/directory/details', 'Admin\DirectoryCategoryController@directorydetails')->name('admin.dircategory.directory.details');
            Route::get('/{id}/directory/test/details', 'Admin\DirectoryCategoryController@testdetails')->name('admin.dircategory.test.details');
            Route::post('/csv-store', 'Admin\DirectoryCategoryController@csvStore')->name('admin.dircategory.data.csv.store');
            Route::get('/export', 'Admin\DirectoryCategoryController@export')->name('admin.dircategory.data.csv.export');
            Route::post('upload/image', 'Admin\DirectoryCategoryController@upload_bulk_images')->name('admin.dircategory.image.upload');
            Route::post('/send/email', 'Admin\DirectoryCategoryController@sendemail')->name('admin.directory.email.send');
        });

        /**  Directory Secondary Category  **/
        Route::group(['prefix' => 'dircategory/sub'], function () {
            Route::get('/', 'Admin\DirectorySubCategoryController@index')->name('admin.dirsubcategory.index');
            Route::get('/create', 'Admin\DirectorySubCategoryController@create')->name('admin.dirsubcategory.create');
            Route::post('/store', 'Admin\DirectorySubCategoryController@store')->name('admin.dirsubcategory.store');
            Route::get('/{id}/edit', 'Admin\DirectorySubCategoryController@edit')->name('admin.dirsubcategory.edit');
            Route::post('/update', 'Admin\DirectorySubCategoryController@update')->name('admin.dirsubcategory.update');
            Route::get('/{id}/delete', 'Admin\DirectorySubCategoryController@delete')->name('admin.dirsubcategory.delete');
            Route::post('updateStatus', 'Admin\DirectorySubCategoryController@updateStatus')->name('admin.dirsubcategory.updateStatus');
            Route::get('/{id}/details', 'Admin\DirectorySubCategoryController@details')->name('admin.dirsubcategory.details');
            Route::post('/csv-store', 'Admin\DirectorySubCategoryController@csvStore')->name('admin.dirsubcategory.data.csv.store');
            Route::get('/export', 'Admin\DirectorySubCategoryController@export')->name('admin.dirsubcategory.data.csv.export');
            Route::post('upload/image', 'Admin\DirectorySubCategoryController@upload_bulk_images')->name('admin.dirsubcategory.image.upload');
        });


        //**  Bussiness Lead management  **/
        Route::group(['prefix'  =>   'bussinesslead'], function () {


            Route::get('/', 'Admin\BussinessLeadController@index')->name('admin.bussinesslead.index');
            Route::get('/create', 'Admin\BussinessLeadController@create')->name('admin.bussinesslead.create');
            Route::post('/store', 'Admin\BussinessLeadController@store')->name('admin.bussinesslead.store');
            Route::get('/{id}/edit', 'Admin\BussinessLeadController@edit')->name('admin.bussinesslead.edit');
            Route::post('/update', 'Admin\BussinessLeadController@update')->name('admin.bussinesslead.update');
            Route::get('/{id}/delete', 'Admin\BussinessLeadController@delete')->name('admin.bussinesslead.delete');
            Route::post('updateStatus', 'Admin\BussinessLeadController@updateStatus')->name('admin.bussinesslead.updateStatus');
            Route::get('/{id}/details', 'Admin\BussinessLeadController@details')->name('admin.bussinesslead.details');
            Route::post('/csv-store', 'Admin\BussinessLeadController@csvStore')->name('admin.bussinesslead.data.csv.store');
            Route::get('/export', 'Admin\BussinessLeadController@export')->name('admin.bussinesslead.data.csv.export');
        });
           //**  Bussiness council management  **/
            Route::group(['prefix'  =>   'council'], function () {


            Route::get('/', 'Admin\BussinessLeadController@council')->name('admin.council.index');
        });
        //**  Advocate registration  **/
        Route::group(['prefix'  =>   'advocate'], function () {
            Route::get('/', 'Admin\AdvocateRegistrationController@index')->name('admin.advocate.index');
            Route::get('/{id}/mail/send', 'Admin\AdvocateRegistrationController@show')->name('admin.advocate.mail');
            Route::get('/{id}/view', 'Admin\AdvocateRegistrationController@details')->name('admin.advocate.view');
            Route::post('/store', 'Admin\AdvocateRegistrationController@store')->name('admin.advocate.store');
            Route::get('/{id}/view', 'Admin\AdvocateRegistrationController@details')->name('admin.advocate.view');
            Route::get('/template/edit', 'Admin\AdvocateRegistrationController@edit')->name('admin.advocate.edit');
            Route::post('/template/update', 'Admin\AdvocateRegistrationController@update')->name('admin.advocate.update');
        });
         //**  event -organiser registration  **/
         Route::group(['prefix'  =>   'event-organiser'], function () {
            Route::get('/', 'Admin\EventRegistrationController@index')->name('admin.event-organiser.index');
            Route::get('/{id}/mail/send', 'Admin\EventRegistrationController@show')->name('admin.event-organiser.mail');
            Route::get('/{id}/view', 'Admin\EventRegistrationController@details')->name('admin.event-organiser.view');
            Route::post('/store', 'Admin\EventRegistrationController@store')->name('admin.event-organiser.store');
            Route::get('/{id}/view', 'Admin\EventRegistrationController@details')->name('admin.event-organiser.view');
            Route::get('/template/edit', 'Admin\EventRegistrationController@edit')->name('admin.advocate.edit');
            Route::post('/template/update', 'Admin\EventRegistrationController@update')->name('admin.advocate.update');
        });
        // settings
        Route::group(['prefix'  =>   'settings'], function () {
            Route::get('/', 'Admin\SettingController@index')->name('admin.settings.index');
            Route::post('/store', 'Admin\SettingController@store')->name('admin.settings.store');
            Route::get('/{id}/view', 'Admin\SettingController@show')->name('admin.settings.view');
            Route::post('/update', 'Admin\SettingController@update')->name('admin.settings.update');
            Route::post('updateStatus', 'Admin\SettingController@updateStatus')->name('admin.settings.updateStatus');
            Route::get('/{id}/delete', 'Admin\SettingController@destroy')->name('admin.settings.delete');
        });

        //about-us

        Route::group(['prefix'  =>   'about-us'], function () {

            Route::get('/', 'Admin\AboutManagementController@index')->name('admin.about-us.index');
            Route::get('/create', 'Admin\AboutManagementController@create')->name('admin.about-us.create');
            Route::post('/store', 'Admin\AboutManagementController@store')->name('admin.about-us.store');
            Route::get('/{id}/edit', 'Admin\AboutManagementController@edit')->name('admin.about-us.edit');
            Route::post('/update', 'Admin\AboutManagementController@update')->name('admin.about-us.update');
            Route::get('/{id}/delete', 'Admin\AboutManagementController@delete')->name('admin.about-us.delete');
            Route::post('updateStatus', 'Admin\AboutManagementController@updateStatus')->name('admin.about-us.updateStatus');
            Route::get('/{id}/details', 'Admin\AboutManagementController@details')->name('admin.about-us.details');
            Route::post('/csv-store', 'Admin\AboutManagementController@csvStore')->name('admin.about-us.data.csv.store');
        });

        //contact-us

        Route::group(['prefix'  =>   'contact-us'], function () {

            Route::get('/', 'Admin\ContactManagementController@index')->name('admin.contact-us.index');
            Route::get('/create', 'Admin\ContactManagementController@create')->name('admin.contact-us.create');
            Route::post('/store', 'Admin\ContactManagementController@store')->name('admin.contact-us.store');
            Route::get('/{id}/edit', 'Admin\ContactManagementController@edit')->name('admin.contact-us.edit');
            Route::post('/update', 'Admin\ContactManagementController@update')->name('admin.contact-us.update');
            Route::get('/{id}/delete', 'Admin\ContactManagementController@delete')->name('admin.contact-us.delete');
            Route::post('updateStatus', 'Admin\ContactManagementController@updateStatus')->name('admin.contact-us.updateStatus');
            Route::get('/{id}/details', 'Admin\ContactManagementController@details')->name('admin.contact-us.details');
            Route::post('/csv-store', 'Admin\ContactManagementController@csvStore')->name('admin.contact-us.data.csv.store');
        });

        //faq

        Route::group(['prefix'  =>   'faq'], function () {

            Route::get('/', 'Admin\FaqManagementController@index')->name('admin.faq.index');
            Route::get('/create', 'Admin\FaqManagementController@create')->name('admin.faq.create');
            Route::post('/store', 'Admin\FaqManagementController@store')->name('admin.faq.store');
            Route::get('/{id}/edit', 'Admin\FaqManagementController@edit')->name('admin.faq.edit');
            Route::post('/update', 'Admin\FaqManagementController@update')->name('admin.faq.update');
            Route::get('/{id}/delete', 'Admin\FaqManagementController@delete')->name('admin.faq.delete');
            Route::post('updateStatus', 'Admin\FaqManagementController@updateStatus')->name('admin.faq.updateStatus');
            Route::get('/{id}/details', 'Admin\FaqManagementController@details')->name('admin.faq.details');
            Route::post('/csv-store', 'Admin\FaqManagementController@csvStore')->name('admin.faq.data.csv.store');
        });
        //faq module

        Route::group(['prefix'  =>   'faqmodule'], function () {

            Route::get('/', 'Admin\FaqController@index')->name('admin.faqmodule.index');
            Route::get('/create', 'Admin\FaqController@create')->name('admin.faqmodule.create');
            Route::post('/store', 'Admin\FaqController@store')->name('admin.faqmodule.store');
            Route::get('/{id}/edit', 'Admin\FaqController@edit')->name('admin.faqmodule.edit');
            Route::post('/update', 'Admin\FaqController@update')->name('admin.faqmodule.update');
            Route::get('/{id}/delete', 'Admin\FaqController@delete')->name('admin.faqmodule.delete');
            Route::post('updateStatus', 'Admin\FaqController@updateStatus')->name('admin.faqmodule.updateStatus');
            Route::get('/{id}/details', 'Admin\FaqController@details')->name('admin.faqmodule.details');
            Route::post('/csv-store', 'Admin\FaqController@csvStore')->name('admin.faqmodule.data.csv.store');
            Route::get('/export', 'Admin\FaqController@export')->name('admin.faqmodule.data.csv.export');
        });

        //splash

        Route::group(['prefix'  =>   'splash'], function () {

            Route::get('/', 'Admin\IndexManagementController@index')->name('admin.splash.index');
            Route::get('/create', 'Admin\IndexManagementController@create')->name('admin.splash.create');
            Route::post('/store', 'Admin\IndexManagementController@store')->name('admin.splash.store');
            Route::get('/{id}/edit', 'Admin\IndexManagementController@edit')->name('admin.splash.edit');
            Route::post('/update', 'Admin\IndexManagementController@update')->name('admin.splash.update');
            Route::get('/{id}/delete', 'Admin\IndexManagementController@delete')->name('admin.splash.delete');
            Route::post('updateStatus', 'Admin\IndexManagementController@updateStatus')->name('admin.splash.updateStatus');
            Route::get('/{id}/details', 'Admin\IndexManagementController@details')->name('admin.splash.details');
            Route::post('/csv-store', 'Admin\IndexManagementController@csvStore')->name('admin.splash.data.csv.store');
        });
        //demo image`

        Route::group(['prefix'  =>   'demo-image'], function () {

            Route::get('/', 'Admin\DemoImageController@index')->name('admin.demo-image.index');
            Route::get('/create', 'Admin\DemoImageController@create')->name('admin.demo-image.create');
            Route::post('/store', 'Admin\DemoImageController@store')->name('admin.demo-image.store');
            Route::get('/{id}/edit', 'Admin\DemoImageController@edit')->name('admin.demo-image.edit');
            Route::post('/update', 'Admin\DemoImageController@update')->name('admin.demo-image.update');
            Route::get('/{id}/delete', 'Admin\DemoImageController@delete')->name('admin.demo-image.delete');
            Route::post('updateStatus', 'Admin\DemoImageController@updateStatus')->name('admin.demo-image.updateStatus');
            Route::get('/{id}/details', 'Admin\DemoImageController@details')->name('admin.demo-image.details');
            Route::post('/csv-store', 'Admin\DemoImageController@csvStore')->name('admin.demo-image.data.csv.store');
        });
         //seo`

         Route::group(['prefix'  =>   'seo'], function () {

            Route::get('/', 'Admin\SeoController@index')->name('admin.seo.index');
            Route::get('/{id}/edit', 'Admin\SeoController@edit')->name('admin.seo.edit');
            Route::post('/update', 'Admin\SeoController@update')->name('admin.seo.update');
            Route::get('/{id}/details', 'Admin\SeoController@details')->name('admin.seo.details');
        });

        //frontend-collection

        Route::group(['prefix'  =>   'forntendcollection'], function () {

            Route::get('/', 'Admin\CollectionManagementController@index')->name('admin.forntendcollection.index');
            Route::get('/create', 'Admin\CollectionManagementController@create')->name('admin.forntendcollection.create');
            Route::post('/store', 'Admin\CollectionManagementController@store')->name('admin.forntendcollection.store');
            Route::get('/{id}/edit', 'Admin\CollectionManagementController@edit')->name('admin.forntendcollection.edit');
            Route::post('/update', 'Admin\CollectionManagementController@update')->name('admin.forntendcollection.update');
            Route::get('/{id}/delete', 'Admin\CollectionManagementController@delete')->name('admin.forntendcollection.delete');
            Route::post('updateStatus', 'Admin\CollectionManagementController@updateStatus')->name('admin.forntendcollection.updateStatus');
            Route::get('/{id}/details', 'Admin\CollectionManagementController@details')->name('admin.forntendcollection.details');
            Route::post('/csv-store', 'Admin\CollectionManagementController@csvStore')->name('admin.forntendcollection.data.csv.store');
        });

        Route::group(['prefix'  =>   'event'], function () {
            Route::get('/', 'Admin\EventController@index')->name('admin.event.index');
            Route::get('/create', 'Admin\EventController@create')->name('admin.event.create');
            Route::post('/store', 'Admin\EventController@store')->name('admin.event.store');
            Route::get('/{id}/edit', 'Admin\EventController@edit')->name('admin.event.edit');
            Route::post('/update', 'Admin\EventController@update')->name('admin.event.update');
            Route::get('/{id}/delete', 'Admin\EventController@delete')->name('admin.event.delete');
            Route::post('updateStatus', 'Admin\EventController@updateStatus')->name('admin.event.updateStatus');
            Route::get('/{id}/details', 'Admin\EventController@details')->name('admin.event.details');
        });

        Route::group(['prefix'  =>   'deal'], function () {
            Route::get('/', 'Admin\DealController@index')->name('admin.deal.index');
            Route::get('/create', 'Admin\DealController@create')->name('admin.deal.create');
            Route::post('/store', 'Admin\DealController@store')->name('admin.deal.store');
            Route::get('/{id}/edit', 'Admin\DealController@edit')->name('admin.deal.edit');
            Route::post('/update', 'Admin\DealController@update')->name('admin.deal.update');
            Route::get('/{id}/delete', 'Admin\DealController@delete')->name('admin.deal.delete');
            Route::post('updateStatus', 'Admin\DealController@updateStatus')->name('admin.deal.updateStatus');
            Route::get('/{id}/details', 'Admin\DealController@details')->name('admin.deal.details');
        });

        Route::group(['prefix' => 'query'], function () {
            Route::get('/', 'Admin\QueryController@index')->name('admin.query.index');
            Route::get('/detail/{id}', 'Admin\QueryController@detail')->name('admin.query.detail');
            Route::post('/query/updateStatus', 'Admin\QueryController@updateStatus')->name('admin.query.updateStatus');
            Route::get('delete/{id}', 'Admin\QueryController@delete')->name('admin.query.delete');

            Route::get('/catagory', 'Admin\QueryCatagoryController@index')->name('admin.query.catagory.index');
            Route::get('/catagory/create', 'Admin\QueryCatagoryController@create')->name('admin.query.catagory.create');
            Route::post('/catagory/create', 'Admin\QueryCatagoryController@store')->name('admin.query.catagory.store');
            Route::get('/catagory/delete/{id}', 'Admin\QueryCatagoryController@delete')->name('admin.query.catagory.delete');
            Route::post('/catagory/updateStatus', 'Admin\QueryCatagoryController@updateStatus')->name('admin.query.catagory.updateStatus');
        });

        Route::group(['prefix' => 'user-suggestion'], function () {
            Route::get('/', 'Admin\SuggestionController@index')->name('admin.user-suggestion.index');
            Route::get('/detail/{id}', 'Admin\SuggestionController@detail')->name('admin.user-suggestion.detail');
            Route::post('/query/updateStatus', 'Admin\SuggestionController@updateStatus')->name('admin.user-suggestion.updateStatus');
            Route::get('delete/{id}', 'Admin\SuggestionController@delete')->name('admin.user-suggestion.delete');
        });

        Route::group(['prefix' => 'csv'], function () {
            Route::get('/', 'Admin\HelpController@csv')->name('admin.csv-activity.index');
        });

        //**  Category management   **/
        Route::group(['prefix'  =>   'helpcategory'], function () {
            Route::get('/', 'Admin\HelpCategoryController@index')->name('admin.helpcategory.index');
            Route::get('/create', 'Admin\HelpCategoryController@create')->name('admin.helpcategory.create');
            Route::post('/store', 'Admin\HelpCategoryController@store')->name('admin.helpcategory.store');
            Route::get('/{id}/edit', 'Admin\HelpCategoryController@edit')->name('admin.helpcategory.edit');
            Route::post('/update', 'Admin\HelpCategoryController@update')->name('admin.helpcategory.update');
            Route::get('/{id}/delete', 'Admin\HelpCategoryController@delete')->name('admin.helpcategory.delete');
            Route::post('updateStatus', 'Admin\HelpCategoryController@updateStatus')->name('admin.helpcategory.updateStatus');
            Route::get('/{id}/details', 'Admin\HelpCategoryController@details')->name('admin.helpcategory.details');
            Route::post('/csv-store', 'Admin\HelpCategoryController@csvStore')->name('admin.helpcategory.data.csv.store');
            Route::get('/export', 'Admin\HelpCategoryController@export')->name('admin.helpcategory.data.csv.export');
        });

        //**  Sub category management  **/
        Route::group(['prefix'  =>   'helpsubcategory'], function () {
            Route::get('/', 'Admin\HelpSubCategoryController@index')->name('admin.helpsubcategory.index');
            Route::get('/create', 'Admin\HelpSubCategoryController@create')->name('admin.helpsubcategory.create');
            Route::post('/store', 'Admin\HelpSubCategoryController@store')->name('admin.helpsubcategory.store');
            Route::get('/{id}/edit', 'Admin\HelpSubCategoryController@edit')->name('admin.helpsubcategory.edit');
            Route::post('/update', 'Admin\HelpSubCategoryController@update')->name('admin.helpsubcategory.update');
            Route::get('/{id}/delete', 'Admin\HelpSubCategoryController@delete')->name('admin.helpsubcategory.delete');
            Route::post('updateStatus', 'Admin\HelpSubCategoryController@updateStatus')->name('admin.helpsubcategory.updateStatus');
            Route::get('/{id}/details', 'Admin\HelpSubCategoryController@details')->name('admin.helpsubcategory.details');
            Route::post('/csv-store', 'Admin\HelpSubCategoryController@csvStore')->name('admin.helpsubcategory.data.csv.store');
            Route::get('/export', 'Admin\HelpSubCategoryController@export')->name('admin.helpsubcategory.data.csv.export');
        });

        Route::group(['prefix'  =>   'userhelp'], function () {
            Route::get('/', 'Admin\HelpController@index')->name('admin.userhelp.index');
            Route::get('/create', 'Admin\HelpController@create')->name('admin.userhelp.create');
            Route::post('/store', 'Admin\HelpController@store')->name('admin.userhelp.store');
            Route::get('/{id}/edit', 'Admin\HelpController@edit')->name('admin.userhelp.edit');
            Route::post('/update', 'Admin\HelpController@update')->name('admin.userhelp.update');
            Route::get('/{id}/delete', 'Admin\HelpController@delete')->name('admin.userhelp.delete');
            Route::post('updateStatus', 'Admin\HelpController@updateStatus')->name('admin.userhelp.updateStatus');
            Route::get('/{id}/details', 'Admin\HelpController@details')->name('admin.userhelp.details');
            Route::post('/csv-store', 'Admin\HelpController@csvStore')->name('admin.userhelp.data.csv.store');
            Route::get('/export', 'Admin\HelpController@export')->name('admin.userhelp.data.csv.export');
        });

        Route::group(['prefix' => 'contact-form'], function () {
            Route::get('/', 'Admin\ContactController@index')->name('admin.contact-form.index');
            Route::get('/detail/{id}', 'Admin\ContactController@detail')->name('admin.contact-form.detail');
        });

        Route::group(['prefix' => 'email-subscription'], function () {
            Route::get('/', 'Admin\SubscriptionController@index')->name('admin.email-subscription.index');
            Route::get('/detail/{id}', 'Admin\SubscriptionController@detail')->name('admin.email-subscription.detail');
        });

        Route::group(['prefix' => 'email/master'], function () {
            Route::get('/', 'Admin\EmailMasterController@index')->name('admin.email.master.index');
            Route::get('/create', 'Admin\EmailMasterController@create')->name('admin.email.master.create');
            Route::post('/store', 'Admin\EmailMasterController@store')->name('admin.email.master.store');
            Route::get('/{id}/edit', 'Admin\EmailMasterController@edit')->name('admin.email.master.edit');
            Route::post('/update', 'Admin\EmailMasterController@update')->name('admin.email.master.update');
            Route::get('/{id}/details', 'Admin\EmailMasterController@details')->name('admin.email.master.details');
        });

        Route::group(['prefix' => 'job/scrap'], function () {
            Route::get('/', 'Admin\JobScrapController@index')->name('admin.job.scrap.index');
            Route::post('/store', 'Admin\JobScrapController@store')->name('admin.job.scrap.store');
        });

        //**  blog management  **/
        Route::group(['prefix'  =>   'review'], function () {
            Route::get('/', 'Admin\ReviewController@index')->name('admin.review.index');
            Route::get('/{id}/delete', 'Admin\ReviewController@delete')->name('admin.review.delete');
            Route::post('updateStatus', 'Admin\ReviewController@updateStatus')->name('admin.review.updateStatus');
          
            Route::get('/{id}/details', 'Admin\ReviewController@details')->name('admin.review.details');
        });

    });
});

Route::view('/send/business/mail','admin.mail.business-register');


// Script desc - job scrap
Route::group(['prefix' => 'job/scrap'], function () {
    // Route::get('/', 'Admin\JobScrapController@index')->name('admin.job.scrap.index');
    // Route::post('/store', 'Admin\JobScrapController@store')->name('admin.job.scrap.store');
    Route::get('/store/postcode', 'Admin\JobScrapController@storePostcode')->name('admin.job.scrap.postcode.store');
    Route::get('/store/suburb', 'Admin\JobScrapController@storeSuburb')->name('admin.job.scrap.suburb.store');
});


// Script desc - business, when uploading data from CSV, has NULL as cateory id, sort them and fix their category
Route::get('/cat/match', 'Admin\TestController@import');
Route::post('/cat/match/post', 'Admin\TestController@importPost');
// status - COMPLETE


// Script desc - fetch data from STAGING 2 to STAGING 1
Route::get('/fetch/data/staging/page/{page}', 'Admin\TestController@fetch');
Route::get('/fetch/staging/all/directory', 'Admin\TestController@allDirectory');
// status - COMPLETE

// Data upload - from 'directories_sorted_2' to 'directories'
Route::get('/upload/dir_stag/dir', 'Admin\TestController@directoryDataUpload');


// Job data - slug update
Route::get('/admin/job/slug/update', 'Admin\TestController@jobSlugUpdate');
