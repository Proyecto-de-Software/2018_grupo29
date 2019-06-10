<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [ 'value' ];
    
    public static function systemPages()
    {
    	return Configuration::where('key','pagination')->get();
    }

    public static function maintenance()
    {
    	return Configuration::where('key','maintenance')->get();
    }

    public static function email()
    {
    	return Configuration::where('key','email')->get();
    }

    public static function title()
    {
    	return Configuration::where('key','title')->get();
    }
}
