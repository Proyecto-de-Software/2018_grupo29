<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    public function consultations(){

    	return $this->hasMany('App\Consultation');
    }
}
