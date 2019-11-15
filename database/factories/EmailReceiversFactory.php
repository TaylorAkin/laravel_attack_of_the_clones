<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Email_Receivers;
use Faker\Generator as Faker;

$factory->define(Email_Receivers::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(Email::class)->create()->id;
        },

        'email_id'  => function(){
            return factory(Email::class)->create()->id;
        }
    ];
});
