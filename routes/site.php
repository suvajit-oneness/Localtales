<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// use App\Models\EventOrganiser;

// homepage
Route::get('/', 'Site\IndexController@index')->name('index');

// postcode
Route::get('postcode', 'Site\PostcodeController@index')->name('postcode-index');
Route::get('postcode/{postcode}', 'Site\PostcodeController@detail')->name('postcode');

// suburb
Route::get('suburb', 'Site\SuburbController@index')->name('suburb-index');
Route::get('suburb/{slug}', 'Site\SuburbController@detail')->name('suburb-details');

// directory
Route::get('directory','Site\DirectoryController@index')->name('directory');
Route::get('directory/{slug}','Site\DirectoryController@detail')->name('directory.detail');

// collection
Route::get('/collection', 'Site\CollectionController@index')->name('collection.home');
Route::get('/collection/{slug}', 'Site\CollectionController@detail')->name('collection');

// category
Route::get('category','Site\CategoryController@index')->name('category-home');
Route::get('category/{slug}','Site\CategoryController@detail')->name('category');









// Route::get('/','Site\HomeController@index')->name('site.home');
Route::get('events','Site\EventController@index');
Route::get('events/{slug}','Site\EventController@details');
//deals
Route::get('deals','Site\DealController@index');
Route::get('deals/{slug}','Site\DealController@details');
//event organiser 
Route::group(['prefix' => 'eventorganiser'], function () {
	Route::get('login', 'EventOrganiser\LoginController@showLoginForm')->name('eventorganiser.login');
    Route::post('login/check', 'EventOrganiser\LoginController@login')->name('eventorganiser.login.post');
	Route::get('logout', 'EventOrganiser\LoginController@logout')->name('eventorganiser.logout');
});
//business
Route::post('business/profile/update','Site\BusinessController@profilestore')->name('business.profile.update');
Route::get('business/change/password', 'Site\BusinessController@changePassword')->name('business.change.password');
Route::post('update/password', 'Site\BusinessController@updatePassword')->name('business.updatePassword');
Route::get('business/review', 'Site\BusinessController@review')->name('business.review');
Route::get('/business/{dirId}/category/{catId}/delete', 'Site\BusinessController@deleteCat')->name('business.directory.category.delete');

//login
Route::get('login', 'Site\LoginController@showLoginForm')->name('site.login');
Route::post('site-login', 'Site\LoginController@login')->name('site.login.post');
Route::get('register', 'Site\LoginController@register')->name('site.register');
Route::post('site-register', 'Site\LoginController@userCreate')->name('site.register.post');
Route::get('site-logout', 'Site\LoginController@logout')->name('site.logout');

Route::group(['middleware' => ['auth:user']], function () {
    Route::get('/dashboard', 'Site\DashboardController@index')->name('site.dashboard');
    Route::get('saved-collection','Site\DashboardController@savedCollection')->name('site.dashboard.saved_collection');
    Route::get('/{id}/delete', 'Site\DashboardController@removeSavedCollection')->name('site.dashboard.collection.delete');
    Route::get('saved-deals','Site\DashboardController@savedDeals')->name('site.dashboard.saved_deals');
    Route::get('saved-deals/{id}/delete', 'Site\DashboardController@removeSavedDeals')->name('site.dashboard.deal.delete');
    Route::get('saved-directory','Site\DashboardController@savedDirectories')->name('site.dashboard.saved_businesses');
    Route::get('saved-directory/{id}/delete', 'Site\DashboardController@removeSavedDirectories')->name('site.dashboard.directory.delete');
    Route::get('site-edit-profile', 'Site\DashboardController@editUserProfile')->name('site.dashboard.editProfile');
    Route::post('site-update-profile', 'Site\DashboardController@updateProfile')->name('site.dashboard.updateProfile');
    Route::get('notification-list', 'Site\DashboardController@notificationList')->name('site.dashboard.notificationList');
    Route::get('setting', 'Site\DashboardController@setting')->name('site.dashboard.setting');
    Route::post('site/comments/create', 'Site\LoopController@createComment')->name('site.comment.post');
    Route::get('loop-like/{id}','Site\LoopController@loopLike');
    Route::get('site-save-user-event/{id}','Site\EventController@saveUserEvent');
    Route::get('site-delete-user-event/{id}','Site\EventController@deleteUserEvent');
    Route::get('saved-job','Site\DashboardController@savedJob')->name('site.dashboard.saved_job');
    Route::get('/job/{slug}/delete', 'Site\DashboardController@removeSavedJob')->name('site.dashboard.job.delete');
    Route::get('applied/job','Site\DashboardController@appliedJob')->name('site.dashboard.applied_job');
});

Route::get('/search', 'Site\HomeController@search')->name('site.search');
Route::get('about-us','Site\ContentController@about')->name('about-us');
Route::get('contact-us','Site\ContentController@contact')->name('contact-us');
Route::post('/contact/form/submit', 'Site\ContentController@contactFormstore')->name('contactForm.store');
//email subscription
Route::post('/email/subscription/submit', 'Site\ContentController@emailSubscriptionstore')->name('emailSubscription.store');
Route::get('terms','Site\ContentController@terms')->name('terms-of-use');
Route::get('privacy','Site\ContentController@privacy')->name('privacy-policy');
Route::get('faq','Site\ContentController@faq')->name('faq');





//jobs
Route::get('jobs','Site\JobController@index')->name('front.job.index');
Route::get('jobs/{slug}','Site\JobController@details')->name('front.job.details');
Route::get('jobs/{slug}/apply','Site\JobController@applyform')->name('front.job.apply.index');
Route::post('/save/job', 'Site\JobController@store')->name('front.job.save');
Route::post('/apply/job', 'Site\JobController@jobapply')->name('apply');

// old collection detail page with id & slug
Route::get('/collection/{id}/{slug}', 'Front\IndexController@collection')->name('collection');
// new collection detail page with id & slug


Route::get('/business-signup', 'Front\IndexController@businesssignup')->name('business.signup');
Route::get('/business-signup/{slug}', 'Front\IndexController@businessform')->name('business.form');
//Route::get('/business-signup-page/{id}', 'Front\IndexController@businesssignuppage')->name('business.signup.page');
Route::get('/business-registration', 'Front\IndexController@registrationform')->name('business.details');
//Route::get('/thankyou', 'Front\IndexController@thankyou')->name('thankyou');
Route::post('/business/create', 'Front\IndexController@businessstore')->name('business.store');
Route::post('/business/registration/form', 'Front\IndexController@store')->name('business.registration.store');
Route::post('/business-signup-page/create', 'Front\IndexController@pagestore')->name('business.signuppage.store');
Route::get('/thank-you', 'Front\IndexController@createStepThree')->name('products.create.step.three');
Route::post('directory/create-step-three', 'Front\IndexController@postCreateStepThree')->name('products.create.step.three.post');
Route::post('business/form/{slug}', 'Front\IndexController@businessformUpdate')->name('business.form.update');
//article
Route::get('article/{slug}','Site\ArticleController@details');
Route::get('/article', 'Site\ArticleController@index')->name('article.index');
//article category
Route::get('/article/category/{slug}', 'Site\ArticleCategoryController@index')->name('article.category');
//article sub category
Route::get('/article/category/{catslug}/{slug}', 'Site\ArticleSubCategoryController@index')->name('article.sub.category');
//article tertiary category
Route::get('/article/category/{catslug}/{subcatslug}/{slug}', 'Site\ArticleTertiaryCategoryController@index')->name('article.tertiary.category');
//article tag
Route::get('/article/tag/{tag}', 'Site\ArticleController@articletag')->name('article.tag');

Route::get('search','Site\ArticleController@index')->name('site.search');
Route::post('directory-search','Site\ContentController@search')->name('directory.search');
Route::get('directory-list-3','Site\BusinessController@index');
Route::get('directory-list-2','Site\BusinessController@index2');

Route::post('directory/related','Site\BusinessController@relatedDirectory')->name('directory.related');
Route::get('directory/{id}/{slug}','Site\BusinessController@details');
Route::get('directory-page/{id}/{slug}','Front\IndexController@page');

Route::get('category/{id?}/directory', 'Front\IndexController@categoryWiseDirectory')->name('category.directory');
Route::post('/review/create', 'Front\IndexController@reviewstore')->name('review');
Route::get('site-save-user-directory/{id}','Site\BusinessController@saveUserBusiness');
Route::get('site-delete-user-directory/{id}','Site\BusinessController@deleteUserBusiness');
Route::get('site-save-user-collection/{id}','Front\IndexController@saveUserCollection');
Route::get('site-delete-user-collection/{id}','Front\IndexController@deleteUserCollection');
Route::post('claim-user-collection/{id}','Front\HelpController@claimbusiness')->name('user.claim.business');
Route::post('/claim/ajax', 'Front\HelpController@claimAjax')->name('add.claim.ajax');
//Route::post('/search', 'Front\ContentController@search')->name('search');
Route::get('/raise/query','Front\QueryController@createQuery')->name('user.raise.query');
Route::post('/raise/query', 'Front\QueryController@storeQuery')->name('user.raise.query.store');
Route::post('/user/help/comment', 'Front\HelpController@store')->name('front.help.store');
Route::post('/add/ajax', 'Front\HelpController@helpAjax')->name('add.help.ajax');

// help
Route::name('front.help.')->prefix('help')->group(function() {
	Route::get('/', 'Front\HelpController@index')->name('index');
    Route::get('/category/{slug}', 'Front\HelpController@subcat')->name('subcat');
	Route::get('/article/{slug}', 'Front\HelpController@detail')->name('detail');
});

// directory categories ajax fetch
Route::post('/directory/category/ajax', 'Api\PostcodeController@category')->name('directory.category.ajax');

//advocate registration

Route::get('/advocate/registration', 'Site\AdvocateRegistrationController@index')->name('advocate.registration');
Route::post('/advocate/registration/create', 'Site\AdvocateRegistrationController@store')->name('advocate.registration.store');
//event organiser registration

Route::get('/eventorganiser/registration', 'Site\EventRegistrationController@index')->name('event.registration');
Route::post('/eventorganiser/registration/create', 'Site\EventRegistrationController@store')->name('event.registration.store');


//deal review
Route::post('/deal/review/store', 'Site\DealController@reviewstore')->name('deal.review');
Route::post('/deal/add/ajax', 'Site\DealController@dealAjax')->name('add.deal.ajax');
//business edit profile
Route::get('/business/profile', function () {
    return view('business.auth.edit_profile');
})->name('business.profile');
//Route::post('/business/update/profile', 'Business\LoginController@updateProfile')->name('business.updateProfile');


// sitemap
Route::get('/sitemap_sitemap.xml', 'Site\SitemapController@index');
Route::get('/sitemap_sitemap/{slug?}', 'Site\SitemapController@detail');

// 404
Route::view('/404', 'site.404')->name('404');

// Route::prefix('sitemap_sitemap')->name('sitemap.')->group(function() {
    // Route::get('/', 'Site\SitemapController@index');
//     Route::get('/{slug?}', 'Site\SitemapController@detail');
// });
//related event

Route::post('event/related','Site\EventController@relatedEvent')->name('event.related');
?>
