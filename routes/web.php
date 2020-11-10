<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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

/* Route::get( '/', function () {
    return view( 'welcome' );
} ); */
      //Auth::routes():-
// Authentication Routes...
/*$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');*/

Auth::routes();
Route::get( '/', 'WelcomeController@index' );
Route::get( '/home', 'HomeController@index' )->name( 'home' );
Route::get( '/shout', [HomeController::class,'shoutHome'])->name('shout');
Route::post( '/savestatus', [HomeController::class,'saveStatus'])->name('shout.save');
Route::get( '/profile', [HomeController::class,'profile'])->name('shout.profile');
Route::get( '/shout/{nickname}', [HomeController::class,'publicTimeline'])->name('shout.public'); //to show publc timeline
Route::post( '/saveprofile', [HomeController::class,'saveProfile'])->name('shout.saveprofile');
Route::get( '/shout/makefriend/{friendId}', [HomeController::class,'makeFriend'])->name('shout.makefriend');
Route::get( '/shout/unfriend/{friendId}', [HomeController::class,'unFriend'])->name('shout.unfriend');


