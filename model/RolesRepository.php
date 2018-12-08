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
        $answer = $this->queryList("SELECT p.nombre, p.id FROM rol_tiene_permiso rtp INNER JOIN permiso p ON p.id = rtp.permiso_id WHERE rtp.rol_id = :id",["id" => $id]);
        return $answer;
    }

    public function getPermisos(){
        $answer = $this->queryList("SELECT * FROM permiso",[]);
        return $answer;
    }

    public function agregarRol($nombre) {
        $answer = $this->queryDevuelveId("INSERT INTO `rol` (`id`, `nombre`) VALUES (NULL, :nombre)",["nombre" => $nombre]);
        return $answer;
    }

    public function existeRol($nombre) {
        $answer = $this->queryList("SELECT * FROM rol WHERE nombre = :nombre",["nombre" => $nombre]);
        return $answer;
    }

    public function agregarPermisoARol($datos) {
        $this->queryList("INSERT INTO `rol_tiene_permiso` (`rol_id`, `permiso_id`) VALUES (:id_rol, :id_permiso)",["id_rol" => $datos['id'], "id_permiso" => $datos['permiso']]);
    }

    public function eliminarRol($id) {
        $this->queryList("DELETE FROM usuario_tiene_rol WHERE rol_id = :id",["id" => $id]);
        $this->queryList("DELETE FROM rol_tiene_permiso WHERE rol_id = :id",["id" => $id]);
        $this->queryList("DELETE FROM rol WHERE id = :id",["id" => $id]);
    }

    public function updateNombreRol($datos){
        $this->queryList("UPDATE `rol` SET `nombre` = :nombre WHERE `rol`.`id` = :id",["nombre" => $datos['nombre'],"id" => $datos['id_rol']]);
    }

}