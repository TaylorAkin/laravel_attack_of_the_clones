<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Email_Senders;
use Faker\Generator as Faker;

$factory->define(Email_Senders::class, function (Faker $faker) {
    return [
   
            'user_id' => function(){
                return factory(Email::class)->create()->id;
            },
    
            'email_id'  => function(){
                return factory(Email::class)->create()->id;
            }
       
    ];
});
