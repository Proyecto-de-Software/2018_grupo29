<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Role;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'is_active', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){

        return $this->belongsToMany('App\Role', 'role_user');
    }

    public function scopeActive($query, $is_active)
    {
        return $query->where('is_active', 'LIKE', "%$is_active%");
    }

    public function scopeUsername($query, $username)
    {
        return $query->where('username', 'LIKE', "%$username%");
    }

    public function rolesUserDoNotOwn() {
        # Esto seguramente se puede hacer más elegante.
        $arr = array();
        foreach ($this->roles as $role) {
            array_push($arr, $role->id);
        }
        return Role::whereNotIn('id', $arr)->get();
    }
}
