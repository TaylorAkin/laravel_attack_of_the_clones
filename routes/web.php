<?php

use App\Http\Resources\UserCollection as UserResource;
use App\User;
use App\Email_Receivers;
use App\Http\Resources\Email_ReceiversCollection;
use App\Email;
use App\Http\Resources\EmailCollection;
use App\Http\Resources\SentEmailCollection;
use App\Http\Resources\ReceivedEmailCollection;
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




Route::get('/inbox/{id}', function ($id) {
    // this gets the emails by receiver id, but doesn't have senders
    $emails = App\Email_Receivers::where("user_id", $id)->with('emails')->get();
    // TODO: filter or query by user id
    //dd($emails);
    $emails->map(function ($email_receiver) {
        $email_receiver->sender = App\Email_Senders::where("email_id", $email_receiver->email_id)->with('user')->get();
        return $email_receiver;
    });
    //$emails->load('emails');
    //dd($emails);
    
    return new SentEmailCollection ($emails);
    // return [
        //     'data' => $e,
        //     'links' => [
            //         'self' => 'link-value',
            //     ],
            // ];
        });
        
        Route::get('/sent/{id}', function ($id) {
            // this gets the emails by receiver id, but doesn't have senders
            $emails = App\Email_Senders::where("user_id", $id)->with('emails')->get();
            // TODO: filter or query by user id
            //dd($emails);
            $emails->map(function ($email_sender) {
                $email_sender->receiver = App\Email_Receivers::where("email_id", $email_sender->email_id)->with('user')->get();
                return $email_sender;
            });
            //$emails->load('emails');
            //dd($emails);
            
            return new ReceivedEmailCollection ($emails);
            // return [
                //     'data' => $e,
                //     'links' => [
                    //         'self' => 'link-value',
                    //     ],
                    // ];
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
                
                // Route::get('/inbox/{userid}', function ($userid) {
                //     // $received = Email_Receivers::all()->where('user_id', $userid);
                //     // $received = App\Email_Receivers::with('emails')->with('user')->where('user_id' , '=', '1')->get();
                //     $emails = App\Email_Receivers::with('emails')->with('user')->where('user_id', '=', $userid)->get();
                
                
                
                //     // ->join('emails', 'email_id', '=', 'email.email_id')
                //     // ->join('users', 'user_id', '=', 'users.user_id')
                //     // ->select('email_receivers.*', 'users.name', 'emails.subject')
                //     // ->get();
                
                //     $emailarr = [];
                //     foreach($emails as $e){
                //         // $data = {
                //         //     'sendername' = $r->user->name;
                
                //         // }
                //        array_push($emailarr, $e->emails, $e->user->name);
                //     }
                //     return [
                //         'data' => $emailarr,
                //         'link' => [
                //             'self' => 'link-value',
                //         ],
                //     ];
                   
                // });

                
                // Route::get('/sent/{userid}', function ($userid) {
                    //     // $sentAndReceived = App\Email::with('sender')->with('receiver')->where('id', '=', '$userid')->get();
                    //     $emails = App\Email_Senders::with('emails')->with('user')->where('user_id', '=', $userid)->get();
                    
                    //     // $received = Email_Senders::all()->where('user_id', $userid);
                    //     $emailarr = [];
                    //     foreach($emails as $email){
                        //        array_push($emailarr, $email);
                        //     }
                        //     //dd($emailarr);
                        //     return [
//         'data' => $emailarr,
//         'links' => [
//             'self' => 'link-value',
//         ],
//     ];
 
// });