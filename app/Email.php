<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    
    //inverse
    public function sender(){
        return $this->hasOne('App\Email_Senders');
    }

    public function receiver(){
        return $this->hasMany('App\Email_Receivers');
    }

    public function archive(){
        return $this->hasOne('App\Archive');
    }

    public function reademails(){
        return $this->hasOne('App\Read_Emails');
    }

    public function starred(){
        return $this->hasOne('App\Starred');
    }

    public function important(){
        return $this->hasOne('App\Important');
    }
    
    // protected $fillable = ['subject', 'body'];

}
