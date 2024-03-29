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
        'first_name', 'last_name', 'birthdate', 'home', 'gender_id', 'has_document', 'dni_number', 'phone_number', 'social_work_id', 'documentation_type_id', 'location_id', 'health_region_id', 'folder_number', 'medical_history_number', 'place_of_birth'
    ];

    public function scopeSearch($query, $first_name, $last_name, $dni_number) {
    	return $query->where('first_name', 'LIKE', "%$first_name%")->where('last_name', 'LIKE', "%$last_name%")->
    		where('dni_number', 'LIKE', "%$dni_number%");
    }
}
