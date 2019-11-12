<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Starred extends Model
{
    public function user(){

        return $this->belongsTo('App\User');
        
       }

    public function emails() {

        return $this->belongsTo('App\Email','email_id');
    }
}
