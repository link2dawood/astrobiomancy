<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocale;

/*
|--------------------------------------------------------------------------
| Admin / auth (locale-agnostic)
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', ['uses' => 'LocaleController@adminLogin']);

Route::get('/logout/', [
    'uses' => 'backend\LoginController@logout',
    'as' => 'logout'
]);
Route::get('/login/', [
    'uses' => 'backend\LoginController@login',
    'as' => 'login'
]);
Route::post('/login_action/', [
    'uses' => 'backend\LoginController@login_action',
    'as' => 'login_action'
]);

Route::get('/cronjob', ['uses' => 'website\WebsiteController@deleteUnverifiedUserCron']);

/*
|--------------------------------------------------------------------------
| Language switcher (sets cookie, redirects back)
|--------------------------------------------------------------------------
*/
Route::get('/lang/{switch_to}', ['uses' => 'LocaleController@switch', 'as' => 'lang.switch']);

/*
|--------------------------------------------------------------------------
| Root: redirect to the resolved locale prefix
|--------------------------------------------------------------------------
*/
Route::get('/', ['uses' => 'LocaleController@root']);

/*
|--------------------------------------------------------------------------
| Public website (locale-prefixed)
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => 'en|de'],
], function () {
    Route::get('/', ['uses' => 'website\WebsiteController@index']);
    Route::get('/create-account', ['uses' => 'website\WebsiteController@createaccount']);
    Route::get('/user/login', ['uses' => 'website\WebsiteController@login']);
    Route::post('/user/login', ['uses' => 'website\WebsiteController@userlogin']);
    Route::post('/create-account', ['uses' => 'website\WebsiteController@createuser']);
    Route::get('account-verfiy/{verifycode}', ['uses' => 'website\WebsiteController@verifycode']);

    Route::get('/contact-us', ['uses' => 'website\WebsiteController@contactus']);
    Route::get('/about-us', ['uses' => 'website\WebsiteController@aboutus']);
    Route::get('/privacy-policy', ['uses' => 'website\WebsiteController@privacypolicy']);
    Route::get('/service/{slug}', ['uses' => 'website\WebsiteController@service']);
    Route::get('/page/{slug}', ['uses' => 'website\WebsiteController@page']);
    Route::get('/disclaimer', ['uses' => 'website\WebsiteController@disclaimer']);
    Route::get('/blog', ['uses' => 'website\WebsiteController@blog']);
    Route::get('post/{slug}', ['uses' => 'website\WebsiteController@singlePost']);
    Route::post('post-comment', ['uses' => 'website\WebsiteController@postcomment']);
    Route::post('postorder', ['uses' => 'website\WebsiteController@postorder']);
    Route::get('/testimonials', ['uses' => 'website\WebsiteController@testimonials']);

    Route::group(['middleware' => ['role:User|Admin', 'auth']], function () {
        Route::get('users/account', ['uses' => 'website\AccountController@useraccount']);
        Route::get('users/orders', ['uses' => 'website\AccountController@orders']);
        Route::get('users/logout', ['uses' => 'website\AccountController@logout']);
        Route::post('users/accountupdate', ['uses' => 'website\AccountController@accountupdate']);
        Route::get('users/orders/{id}', ['uses' => 'website\AccountController@userorder']);
        Route::post('users/ordersaveques', ['uses' => 'website\AccountController@ordersaveques']);
        Route::post('users/orders/uploadtempfile', ['uses' => 'website\AccountController@uploadtempfile']);
    });
});

/*
|--------------------------------------------------------------------------
| Admin dashboard (single language, EN)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['role:Admin', 'auth']], function () {
    Route::get('dashboard', ['uses' => 'backend\DashboardController@dashboardData']);
    Route::get('dashboard/orders', ['uses' => 'backend\OrdersController@orders']);
    Route::get('dashboard/orders/delete/{id}', ['uses' => 'backend\OrdersController@deleteorders']);
    Route::post('dashboard/ordersupdate', ['uses' => 'backend\OrdersController@ordersupdate']);
    Route::get('dashboard/orderschat/delete/{id}', ['uses' => 'backend\OrdersController@orderschatdelete']);
    Route::get('dashboard/orders/{id}', ['uses' => 'backend\OrdersController@getorder']);
    Route::post('dashboard/orders/updatereadchat', ['uses' => 'backend\OrdersController@updatereadchat']);
    Route::get('dashboard/settings', ['uses' => 'backend\SettingsController@settings']);
    Route::post('dashboard/settings_save', ['uses' => 'backend\SettingsController@settings_save']);
    Route::get('dashboard/blog/post', ['uses' => 'backend\BlogController@list']);
    Route::get('dashboard/blog/post/add', ['uses' => 'backend\BlogController@add']);
    Route::post('dashboard/blog/post/add_action', ['uses' => 'backend\BlogController@add_action']);
    Route::get('dashboard/blog/post/edit/{id}', ['uses' => 'backend\BlogController@edit']);
    Route::get('dashboard/blog/post/comments/{id}', ['uses' => 'backend\BlogController@comments']);
    Route::get('dashboard/blog/post/delete/{id}', ['uses' => 'backend\BlogController@delete']);
    Route::get('dashboard/blog/comment/delete/{id}', ['uses' => 'backend\BlogController@deletecomment']);
    Route::post('dashboard/blog/post/update_action', ['uses' => 'backend\BlogController@update_action']);
    Route::get('dashboard/pages/about', ['uses' => 'backend\PagesController@about']);
    Route::get('dashboard/services/{slug}', ['uses' => 'backend\ServicesController@service']);
    Route::post('dashboard/services/save', ['uses' => 'backend\ServicesController@save']);
    Route::post('dashboard/pages/about_save', ['uses' => 'backend\PagesController@about_save']);

    Route::get('dashboard/pages/disclaimer', ['uses' => 'backend\PagesController@disclaimer']);
    Route::post('dashboard/pages/disclaimer_save', ['uses' => 'backend\PagesController@disclaimer_save']);

    Route::get('dashboard/pages/home', ['uses' => 'backend\PagesController@home']);
    Route::post('dashboard/pages/home_save', ['uses' => 'backend\PagesController@home_save']);

    Route::get('dashboard/pages/privacypolicy', ['uses' => 'backend\PagesController@privacypolicy']);
    Route::post('dashboard/pages/privacypolicy_save', ['uses' => 'backend\PagesController@privacypolicy_save']);

    Route::post('dashboard/pages/update', ['uses' => 'backend\PagesController@update']);
    Route::get('dashboard/pages/{slug}', ['uses' => 'backend\PagesController@page']);

    Route::get('/dashboard/media', ['uses' => 'backend\MediaController@list']);
    Route::get('/dashboard/media/add', ['uses' => 'backend\MediaController@add']);
    Route::get('/dashboard/media/delete/{id}', ['uses' => 'backend\MediaController@delete']);
    Route::post('/dashboard/media/add_action', ['uses' => 'backend\MediaController@add_action']);

    Route::get('/dashboard/category', ['uses' => 'backend\CategoryController@list']);
    Route::get('/dashboard/category/add', ['uses' => 'backend\CategoryController@add']);
    Route::post('/dashboard/category/add_action', ['uses' => 'backend\CategoryController@add_action']);
    Route::get('/dashboard/category/edit/{id}', ['uses' => 'backend\CategoryController@edit']);
    Route::get('/dashboard/category/delete/{id}', ['uses' => 'backend\CategoryController@delete']);
    Route::post('/dashboard/category/update_action', ['uses' => 'backend\CategoryController@update_action']);

    // Testimonials
    Route::get('/dashboard/testimonials', ['uses' => 'backend\TestimonialController@index']);
    Route::get('/dashboard/testimonials/add', ['uses' => 'backend\TestimonialController@add']);
    Route::post('/dashboard/testimonials/store', ['uses' => 'backend\TestimonialController@store']);
    Route::get('/dashboard/testimonials/edit/{id}', ['uses' => 'backend\TestimonialController@edit']);
    Route::post('/dashboard/testimonials/update/{id}', ['uses' => 'backend\TestimonialController@update']);
    Route::get('/dashboard/testimonials/delete/{id}', ['uses' => 'backend\TestimonialController@delete']);

    // Menus (navigation manager)
    Route::get('/dashboard/menus', ['uses' => 'backend\MenuController@index']);
    Route::get('/dashboard/menus/add', ['uses' => 'backend\MenuController@add']);
    Route::post('/dashboard/menus/store', ['uses' => 'backend\MenuController@store']);
    Route::get('/dashboard/menus/edit/{id}', ['uses' => 'backend\MenuController@edit']);
    Route::post('/dashboard/menus/update/{id}', ['uses' => 'backend\MenuController@update']);
    Route::get('/dashboard/menus/delete/{id}', ['uses' => 'backend\MenuController@delete']);

    Route::get('/dashboard/admin/users', ['uses' => 'backend\UsersController@adminList']);
    Route::get('/dashboard/users', ['uses' => 'backend\UsersController@list']);
    Route::get('/dashboard/users/delete/{id}', ['uses' => 'backend\UsersController@delete']);
    Route::get('/dashboard/users/edit/{id}', ['uses' => 'backend\UsersController@edit']);
    Route::get('/dashboard/users/add', ['uses' => 'backend\UsersController@add']);
    Route::post('/dashboard/users/add_action', ['uses' => 'backend\UsersController@add_action']);
    Route::post('/dashboard/users/update_action', ['uses' => 'backend\UsersController@update_action']);
});

/*
|--------------------------------------------------------------------------
| Fallback: catch legacy unprefixed URLs and redirect to /{locale}/{path}
|--------------------------------------------------------------------------
| Phase 2 moved every public page under a {locale} prefix. Anything still
| linking to /about-us, /blog, /service/xxx etc. lands here and gets a 301
| to the locale-prefixed equivalent. Admin and internal paths are exempted.
*/
Route::fallback(['uses' => 'LocaleController@fallback']);

