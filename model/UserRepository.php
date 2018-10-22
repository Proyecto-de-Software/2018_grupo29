<?php

/**
 * Description of ResourceRepository
 *
 * @author fede
 */

require_once('model/PDORepository.php');

class UserRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function listAll() {
        $answer = $this->queryList("select * from usuario",[]);
        return $answer;
    }

    public function getPermisos($id) {
        $answer = $this->queryList("
            SELECT p.nombre
            FROM
                usuario u
            INNER JOIN usuario_tiene_rol utr ON
                u.id = utr.usuario_id
            INNER JOIN rol r ON
                r.id = utr.rol_id
            INNER JOIN rol_tiene_permiso rtp ON
                r.id = rtp.rol_id
            INNER JOIN permiso p ON
                p.id = rtp.permiso_id
            WHERE u.id = :id",["id"=>$id]);
        return $answer;
    }

    public function cambiarEstado($datos){
        $this->queryList("UPDATE usuario SET activo=:estado WHERE id=:id ", ["estado"=> $datos['usuario_estado'],"id"=> $datos["usuario_id"]]);
    }

    public function verificarUnicidad($datos) {
        $answer = $this->queryList("SELECT * FROM usuario WHERE username = :username ",["username" => $datos['username']]);
        return $answer;
    }

    public function agregarUsuario($datos) {
        $this->queryList("
            INSERT INTO `usuario` (`id`, `email`, `username`, `password`, `activo`, `updated_at`, `created_at`, `first_name`, `last_name`) VALUES (NULL, :email, :username, :password , 0 , :updated_at, :created_at, :first_name, :last_name)

            ",[
                "email" => $datos['email'], 
                "username" => $datos['username'],
                "password" => $datos['password'],
                "updated_at" => $datos['updated_at'],
                "created_at" => $datos['created_at'],
                "first_name" => $datos['first_name'],
                "last_name" => $datos['last_name']

            ]);
    }
}
