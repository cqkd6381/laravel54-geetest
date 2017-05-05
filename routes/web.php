<?php

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
    return view('welcome');
});

// Route::post('/verify', function () {
//     $captcha = new \Laravist\GeeCaptcha\GeeCaptcha(env('CAPTCHA_ID'), env('PRIVATE_KEY'));
//     if ($captcha->isFromGTServer()) {
//         if($captcha->success()){
//             return 'success';
//         }
//         return 'no';
//     }
//     if ($captcha->hasAnswer()) {
//             return "answer";
//     }
//     return "no answer";
// });

Route::get('/captcha', function () {
    $captcha = new \Laravist\GeeCaptcha\GeeCaptcha(env('CAPTCHA_ID'), env('PRIVATE_KEY'));

    echo $captcha->GTServerIsNormal();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
