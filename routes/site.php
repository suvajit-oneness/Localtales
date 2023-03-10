<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// use App\Models\EventOrganiser;

// homepage
Route::get('/', 'Site\IndexController@index')->name('index');

// postcode
Route::get('postcode', 'Site\PostcodeController@index')->name('postcode-index');
Route::get('postcode/{postcode}', 'Site\PostcodeController@detail')->name('postcode');
Route::post('postcode/lat/lng/update', 'Site\PostcodeController@latLngUpdate')->name('postcode.lat.lng.update');

// suburb
Route::get('suburb', 'Site\SuburbController@index')->name('suburb-index');
Route::get('suburb/{slug}', 'Site\SuburbController@detail')->name('suburb-details');
Route::post('suburb/lat/lng/update', 'Site\SuburbController@latLngUpdate')->name('suburb.lat.lng.update');

// directory
Route::get('directory','Site\DirectoryController@index')->name('directory');
Route::get('directory/{slug}','Site\DirectoryController@detail')->name('directory.detail');
Route::post('directory/related','Site\DirectoryController@relatedDirectory')->name('directory.related');
Route::post('/directory/review/create', 'Site\DirectoryController@reviewstore')->name('directory.review.store');
Route::post('/directory/add/review/ajax', 'Site\DirectoryController@reviewAdd')->name('directory.add.review.ajax');
Route::post('/directory/save/toggle', 'Site\DirectoryController@save')->name('directory.save.toggle');
Route::post('/directory/like/review', 'Site\ReviewController@likeStore')->name('directory.review.like');
Route::post('/directory/dislike/review', 'Site\ReviewController@dislikeStore')->name('directory.review.dislike');
// directory categories ajax fetch
Route::post('/directory/category/ajax', 'Api\PostcodeController@category')->name('directory.category.ajax');
//Route::post('claim-user-collection/{id}','Front\HelpController@claimbusiness')->name('user.claim.business');


// collection
Route::get('/collection', 'Site\CollectionController@index')->name('collection.home');
Route::get('/collection/{slug}', 'Site\CollectionController@detail')->name('collection');

// category
Route::get('category','Site\CategoryController@index')->name('category-home');
Route::get('category/{slug}','Site\CategoryController@detail')->name('category');

// article
Route::get('article', 'Site\ArticleController@index')->name('article.index');
Route::get('article/{slug}','Site\ArticleController@detail')->name('article.detail');
Route::get('/article/category/{slug}', 'Site\ArticleCategoryController@index')->name('article.category');
Route::get('/article/category/{catslug}/{slug}', 'Site\ArticleSubCategoryController@index')->name('article.sub.category');
Route::get('/article/category/{catslug}/{subcatslug}/{slug}', 'Site\ArticleTertiaryCategoryController@index')->name('article.tertiary.category');
Route::get('/article/tag/{tag}', 'Site\ArticleController@articletag')->name('article.tag');

// events
Route::get('events','Site\EventController@index')->name('events.index');
Route::get('events/{slug}','Site\EventController@detail')->name('events.detail');
Route::post('event/related','Site\EventController@relatedEvent')->name('event.related');

// deals
Route::get('deals','Site\DealController@index')->name('deals.index');
Route::get('deals/{slug}','Site\DealController@detail')->name('deals.detail');
Route::post('/deal/review/store', 'Site\DealController@reviewstore')->name('deal.review');
Route::post('/deal/add/ajax', 'Site\DealController@dealAjax')->name('add.deal.ajax');

// jobs
Route::get('jobs','Site\JobController@index')->name('front.job.index');
Route::get('jobs/{slug}','Site\JobController@details')->name('front.job.details');
Route::get('jobs/{slug}/apply','Site\JobController@applyform')->name('front.job.apply.index');
Route::post('/save/job', 'Site\JobController@store')->name('front.job.save');
Route::post('/apply/job', 'Site\JobController@jobapply')->name('apply');

// review
Route::get('review','Site\ReviewController@index')->name('review');

// about-us
Route::get('about-us','Site\ContentController@about')->name('about-us');

// contact-us
Route::get('contact-us','Site\ContentController@contact')->name('contact-us');
Route::post('/contact/form/submit', 'Site\ContentController@contactFormstore')->name('contactForm.store');

// email subscription
Route::post('/email/subscription/submit', 'Site\ContentController@emailSubscriptionstore')->name('emailSubscription.store');

// terms-condition
Route::get('terms','Site\ContentController@terms')->name('terms-of-use');

// privacy policy
Route::get('privacy','Site\ContentController@privacy')->name('privacy-policy');

// faq
Route::get('faq','Site\ContentController@faq')->name('faq');

// sitemap
Route::get('/sitemap_sitemap.xml', 'Site\SitemapController@index');
Route::get('/sitemap_sitemap/{slug?}', 'Site\SitemapController@detail');

// 404
Route::view('/404', 'site.404')->name('404');

// user login
Route::prefix('user/')->name('front.user.')->group(function () {
    Route::get('login', 'Site\LoginController@login')->name('login');
    Route::post('login/check', 'Site\LoginController@check')->name('login.check');
    Route::get('register', 'Site\RegisterController@register')->name('register');
    Route::post('register/store', 'Site\RegisterController@store')->name('register.store');
});
Route::get('logout', 'Site\LoginController@logout')->name('user.logout');

// user dashboard
Route::group(['middleware' => ['auth:user']], function () {
    Route::get('/dashboard', 'Site\UserController@index')->name('site.dashboard');
    Route::get('saved-collection','Site\UserController@savedCollection')->name('site.dashboard.saved_collection');
    Route::get('saved-directory','Site\UserController@savedDirectory')->name('site.dashboard.saved_businesses');
    Route::get('saved-job','Site\UserController@savedJob')->name('site.dashboard.saved_job');
    Route::get('notification', 'Site\UserController@allNotifications')->name('site.dashboard.notificationList');



    Route::get('/{id}/delete', 'Site\UserController@removeSavedCollection')->name('site.dashboard.collection.delete');
    Route::get('saved-deals','Site\UserController@savedDeals')->name('site.dashboard.saved_deals');
    Route::get('saved-deals/{id}/delete', 'Site\UserController@removeSavedDeals')->name('site.dashboard.deal.delete');
    Route::get('saved-directory/{id}/delete', 'Site\UserController@removeSavedDirectories')->name('site.dashboard.directory.delete');
    Route::get('profile/edit', 'Site\UserController@editUserProfile')->name('site.dashboard.editProfile');
    Route::post('site-update-profile', 'Site\UserController@updateProfile')->name('site.dashboard.updateProfile');
    
    Route::get('setting', 'Site\UserController@setting')->name('site.dashboard.setting');
    Route::post('site/comments/create', 'Site\UserController@createComment')->name('site.comment.post');
    Route::get('loop-like/{id}','Site\UserController@loopLike');
    Route::get('site-save-user-event/{id}','Site\UserController@saveUserEvent');
    Route::get('site-delete-user-event/{id}','Site\UserController@deleteUserEvent');
    Route::get('/job/{slug}/delete', 'Site\UserController@removeSavedJob')->name('site.dashboard.job.delete');
    Route::get('applied/job','Site\UserController@appliedJob')->name('site.dashboard.applied_job');
    Route::get('site-save-user-directory/{id}','Site\BusinessController@saveUserBusiness');
    Route::get('site-delete-user-directory/{id}','Site\BusinessController@deleteUserBusiness');
    Route::get('site-save-user-collection/{id}','Front\IndexController@saveUserCollection');
    Route::get('site-delete-user-collection/{id}','Front\IndexController@deleteUserCollection');

    // notification
    Route::get('/notification/setup', 'Site\UserNotificationController@setup')->name('user.notification.setup');
    Route::post('/notification/toggle', 'Site\UserNotificationController@toggle')->name('user.notification.toggle');
});
//news
Route::get('/news', 'Site\NewsController@index')->name('news');
Route::get('/news/{slug}', 'Site\NewsController@detail')->name('news.detail');
//property
Route::get('/properties', 'Site\PropertyController@index')->name('property');
Route::get('/properties/{slug}', 'Site\PropertyController@detail')->name('property.detail');
//school
Route::get('/schools', 'Site\SchoolController@index')->name('schools');
Route::get('/schools/{slug}', 'Site\SchoolController@detail')->name('schools.detail');
//doctor-hospital
Route::get('/doctors-hospital', 'Site\HospitalController@index')->name('doctors');
Route::get('/doctors-hospital/{slug}', 'Site\HospitalController@detail')->name('doctors.detail');
// help
Route::name('front.help.')->prefix('help')->group(function() {
	Route::get('/', 'Front\HelpController@index')->name('index');
    Route::get('/category/{slug}', 'Front\HelpController@subcat')->name('subcat');
	Route::get('/article/{slug}', 'Front\HelpController@detail')->name('detail');
});

Route::post('/claim/ajax', 'Front\HelpController@claimAjax')->name('add.claim.ajax');

//raise query
Route::get('/raise/query','Front\QueryController@createQuery')->name('user.raise.query');
Route::post('/raise/query', 'Front\QueryController@storeQuery')->name('user.raise.query.store');

Route::post('/user/help/comment', 'Front\HelpController@store')->name('front.help.store');
Route::post('/add/ajax', 'Front\HelpController@helpAjax')->name('add.help.ajax');

//Route::get('directory/{id}/{slug}','Site\BusinessController@details');
//Route::get('directory-page/{id}/{slug}','Front\IndexController@page');

Route::get('category/{id?}/directory', 'Front\IndexController@categoryWiseDirectory')->name('category.directory');

//advocate registration

Route::get('/advocate/registration', 'Site\AdvocateRegistrationController@index')->name('advocate.registration');
Route::post('/advocate/registration/create', 'Site\AdvocateRegistrationController@store')->name('advocate.registration.store');

Route::get('search','Site\ArticleController@index')->name('site.search');
Route::post('directory-search','Site\ContentController@search')->name('directory.search');

// get google review for one server to current
Route::get('/test/review', 'Site\TestController@reviewFetch');

// get crawled jobs from one server to current
Route::get('/test/jobs/fetch', 'Site\TestController@jobsFetch');

// postcode weather test
Route::view('/weather/test', 'site.test.postcode');

//Route::get('directory-list-3','Site\BusinessController@index');
//Route::get('directory-list-2','Site\BusinessController@index2');
?>
