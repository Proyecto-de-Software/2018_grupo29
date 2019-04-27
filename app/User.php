<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    public function rolesUserDoNotHave() {

        /*
            Asi lo teniamos antes

             public function getRolesQueNoTieneUnUsuario($id) {
                $answer = $this->queryList("SELECT r.id, r.nombre FROM rol r WHERE r.id NOT IN (SELECT r.id FROM usuario u INNER JOIN usuario_tiene_rol utr ON u.id = utr.usuario_id INNER JOIN rol r ON r.id = utr.rol_id WHERE u.id = :id)",["id" => $id]);
                return $answer;
            }

        */
    }
}
