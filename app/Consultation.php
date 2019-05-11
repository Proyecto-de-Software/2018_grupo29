<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    public function patient(){

    	return $this->belongsTo('App\Patient');
    }

    /*public function scopeSearch($query,$patient_id){
    	return $query->where('patient_id',"$patient_id");
    }*/

    public function consultationsOfPatient($patient_id){
    	return Consultation::where('patient_id',"$patient_id")->get();
    }
}
