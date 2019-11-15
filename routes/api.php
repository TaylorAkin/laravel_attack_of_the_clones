<?php

use Illuminate\Http\Request;

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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'AuthenticationController@login')->name('login');

Route::middleware('auth:api')->group(function(){
    Route::get('/logout', 'AuthenticationController@logout')->name('logout');
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
        
        
        return new SentEmailCollection ($emails);
    
    });
            
    Route::get('/sent/{id}', function ($id) {
        // this gets the emails by receiver id, but doesn't have senders
        $emails = App\Email_Senders::where("user_id", $id)->with('emails')->get();

        $emails->map(function ($email_sender) {
        $email_sender->receiver = App\Email_Receivers::where("email_id", $email_sender->email_id)->with('user')->get();
        return $email_sender;
        });


        return new ReceivedEmailCollection ($emails);

    });
        
        
        Route::get('/archive/{userid}', function ($userid) {
            $received = Archive::all()->where('user_id', $userid);
            $emailarr = [];
            foreach($received as $r){
                array_push($emailarr, $r->emails);
            }
            return $emailarr;
            
        });
        
        Route::get('/starred/{id}', function ($userid) {
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
    
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });






