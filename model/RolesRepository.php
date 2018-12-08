<?php

require_once('model/PDORepository.php');

class RolesRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function getRoles(){
        $answer = $this->queryList("SELECT * FROM rol",[]);
        return $answer;
    }

    public function getPermisosPorRol($id){
        $answer = $this->queryList("SELECT p.nombre FROM rol_tiene_permiso rtp INNER JOIN permiso p ON p.id = rtp.permiso_id WHERE rtp.rol_id = :id",["id" => $id]);
        return $answer;
    }

    public function getPermisos(){
        $answer = $this->queryList("SELECT * FROM permiso",[]);
        return $answer;
    }

}