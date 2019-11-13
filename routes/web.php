<?php

use App\Http\Resources\UserCollection as UserResource;
use App\User;
use App\Email_Receivers;
use App\Http\Resources\Email_ReceiversCollection;
use App\Email;
use App\Http\Resources\EmailCollection;
use App\Email_Senders;
use App\Archive;
use App\Starred;
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user/{id}', function ($id) {

    return new UserResource(User::all()->where('id', ($id)));
});


Route::get('/inbox/{userid}', function ($userid) {
    $received = Email_Receivers::all()->where('user_id', $userid);
    $emailarr = [];
    foreach($received as $r){
       array_push($emailarr, $r->emails);
    }
    return [
        'data' => $emailarr,
        'link' => [
            'self' => 'link-value',
        ],
    ];
    // return new Email_ReceiversCollection($received->emails);
    // return new Email_ReceiversCollection(->emails->get());
});

Route::get('/sent/{userid}', function ($userid) {
    $received = Email_Senders::all()->where('user_id', $userid);
    $emailarr = [];
    foreach($received as $r){
       array_push($emailarr, $r->emails);
    }
    //dd($emailarr);
    return [
        'data' => $emailarr,
        'links' => [
            'self' => 'link-value',
        ],
    ];
 
});

Route::get('/archive/{userid}', function ($userid) {
    $received = Archive::all()->where('user_id', $userid);
    $emailarr = [];
    foreach($received as $r){
       array_push($emailarr, $r->emails);
    }
    return $emailarr;
 
});

Route::get('/starred/{userid}', function ($userid) {
    $received = Starred::all()->where('user_id', $userid);
    $emailarr = [];
    foreach($received as $r){
       array_push($emailarr, $r->emails);
    }
    return [
        'data' => $emailarr,
        'links' => [
            'self' => 'link-value',
        ],
    ];
 
});


Route::get('/emails/{id}', function ($id) {

    return new EmailCollection(Email::all()->where('id', $id));
});