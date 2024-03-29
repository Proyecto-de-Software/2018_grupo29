<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $fillable = [
    	'name', 'director', 'phone_number', 'x_coordinate', 'y_coordinate', 'institution_type_id'
    ];

    public static function coordinates($id){
    	return Institution::where('id',$id)->get('x_coordinate','y_coordinate');
    }
}
