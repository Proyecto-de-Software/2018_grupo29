<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    public function patient(){

    	return $this->belongsTo('App\Patient');
    }

    public function reason(){

    	return $this->belongsTo('App\Reason');
    }

    public function accompaniment(){

        return $this->belongsTo('App\Accompaniment');
    }

    public function treatment(){

        return $this->belongsTo('App\Treatment');
    }

    protected $fillable = [
    	'date','articulation','was_internment','diagnostic','observations','accompaniment_id','reason_id','derivation_id','treatment_id'
    ];

    public function consultationsOfPatient($patient_id){
        return Consultation::where('patient_id',$patient_id)->with(['reason'])->get();
    }
}
