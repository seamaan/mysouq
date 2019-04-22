<?php
#
#   Cpanel Constant
#
####################
view()->share('cpanel',url('public/cpanel').'/');
////////////////////////////
///
///
define('cp','myadmin/');
define('cp_url','public/cpanel');
/////
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix'=>cp],function(){
    Config::set('auth.defines','admin');

    Route::get('login','Cpanel\AdminAuthController@showLoginForm');
    Route::post('login','Cpanel\AdminAuthController@login');
    Route::get('logout','Cpanel\AdminAuthController@logout')->name('admin.logout');

    Route::group(['middleware'=>'AdminAuth:admin'],function(){
        Route::get('/','Cpanel\MasterController@index');
        Route::get('settings','Cpanel\Settings\SettingController@index');
        Route::post('settings','Cpanel\Settings\SettingController@store');


        ///
        ///
        Route::get('fm', function () {
            return view('cpanel.fm.mfm');
        });
        Route::get('pop', function () {
            return view('cpanel.fm.popup');
        });

        Route::get('popup', function () {
            return view('cpanel.fm.pop');
        });

    });

});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/asa', function () {
    return view('asa');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
