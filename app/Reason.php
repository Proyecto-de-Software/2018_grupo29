<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    public function consultations(){

    	return $this->hasMany('App\Consultation');
    }
}
