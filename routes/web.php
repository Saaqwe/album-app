<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

Route::get('/', function () {
//    return view('welcome');
    return view('main_page');
});

/** auth routes */
Route::name('user.')->group(function () {


    Route::get('login', [LoginController::class, 'index']);

    Route::post('/login', [LoginController::class, 'login']);

    Route::match(array('GET','POST'),'logout',[LoginController::class, 'logout']);

//    Route::post('/logout', [LoginController::class, 'logout']);


//    Route::get('/logout', function() {
//        Auth::logout();
//        return redirect("/");
//    })->name('logout');

    Route::view('/private', 'private')
        ->middleware('auth')->name('private');


    Route::get('registration', function () {
        if(Auth::check()) {
            return redirect(route('user.private'));
        }
       return view('registration');
    })->name('registration');

    Route::post('/registration', [RegisterController::class, 'save']);


});



