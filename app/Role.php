<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function users(){

    	return $this->belongsToMany('App\User');
    }

    public function permissions(){

    	return $this->belongsToMany('App\Permission');
    }

    public function permissionsRoleDoNotOwn(){

    	# Esto seguramente se puede hacer más elegante.
        $arr = array();
        foreach ($this->perms as $perm) {
            array_push($arr, $perm->id);
        }

        return Permission::whereNotIn('id', $arr)->get();
    }
}
