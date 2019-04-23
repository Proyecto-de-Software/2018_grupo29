<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function consultations(){

    	return $this->hasMany('App\Consultation');
    }

    public function gender(){

    	return $this->belongsTo('App\Gender');
    }

    protected $fillable = [
        'first_name', 'last_name', 'birthdate', 'home', 'gender_id', 'has_document', 'dni_number', 'phone_number'
    ];
}
