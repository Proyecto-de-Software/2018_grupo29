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

    public function listAll($id) {
        $answer = $this->queryList("select * from usuario where id <> :id",["id" => $id]);
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

    public function buscarUsuarioSinActivo($datos) {
        $answer = $this->queryList("SELECT * FROM usuario WHERE id <> :id AND username LIKE CONCAT('%', :username, '%')",["username" => $datos['username'], "id" => $datos['id']]);
        return $answer;
    }

    public function buscarUsuarioConActivo($datos) {
        $answer = $this->queryList("SELECT * FROM usuario WHERE id <> :id AND username LIKE CONCAT('%', :username, '%') AND activo = :activo",["username" => $datos['username'],"activo" => $datos['activo'], "id" => $datos['id']]);
        return $answer;
    }

    public function eliminarUsuario($id) {
        $this->queryList("DELETE FROM usuario_tiene_rol WHERE usuario_id = :id",["id" => $id]);
        $this->queryList("DELETE FROM usuario WHERE id = :id",["id" => $id]);
    }

    public function datosUsuario($id){
        $answer = $this->queryList("SELECT * FROM usuario where id=:id", ["id" => $id]);
        return $answer[0];
    }

    public function actualizarUsuario($datos){
        $this->queryList("UPDATE usuario set username=:username, email=:email, password=:pwd, activo=0, first_name=:first_name, last_name=:last_name where id=:id"
            ,[
                "username" => $datos["username"],
                "email" => $datos["email"],
                "pwd" => $datos["password"],
                "first_name" => $datos["first_name"],
                "last_name" => $datos["last_name"],
                "id" => $datos["id_usuario"]
            ]);
    }

    public function getRoles(){
        $answer = $this->queryList("SELECT * FROM rol",[]);
        return $answer;
    }

    public function getRolesDeUsuario($id) {
        $answer = $this->queryList("SELECT r.nombre, r.id FROM usuario u INNER JOIN usuario_tiene_rol utr ON u.id = utr.usuario_id INNER JOIN rol r ON r.id = utr.rol_id WHERE u.id = :id",["id" => $id]);
        return $answer;
    }

    public function getRolesQueNoTieneUnUsuario($id) {
        $answer = $this->queryList("SELECT r.id, r.nombre FROM rol r WHERE r.id NOT IN (SELECT r.id FROM usuario u INNER JOIN usuario_tiene_rol utr ON u.id = utr.usuario_id INNER JOIN rol r ON r.id = utr.rol_id WHERE u.id = :id)",["id" => $id]);
        return $answer;
    }

    public function asignarRol($datos) {
        $this->queryList("INSERT INTO usuario_tiene_rol (usuario_id, rol_id) VALUES (:usuario_id, :rol_id)",["usuario_id" => $datos['usuario_id'],"rol_id" => $datos['rol_id']]);
    }

    public function desasignarRol($datos) {
        $this->queryList("DELETE FROM usuario_tiene_rol WHERE usuario_id = :usuario_id AND rol_id = :rol_id",["usuario_id" => $datos['usuario_id'], "rol_id" => $datos['rol_id']]);
    }

    public function getIdByUsername($username) {
        $answer = $this->queryList("SELECT id FROM usuario WHERE username = :username",["username" => $username]);
        return $answer;
    }
}

