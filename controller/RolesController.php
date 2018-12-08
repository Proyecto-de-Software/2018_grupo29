<?php

require_once('controller/ResourceController.php');
require_once('model/SessionRepository.php');
require_once('model/RolesRepository.php');

class RolesController {

	private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }  

    public function menuRoles(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if ((in_array('rol_index', $_SESSION['permisos'])) or (in_array('rol_new', $_SESSION['permisos'])) (in_array('rol_update', $_SESSION['permisos'])) or (in_array('rol_destroy', $_SESSION['permisos'])) or (in_array('rol_show', $_SESSION['permisos']))){
                ResourceController::getInstance()->mostrarHTMLConParametros('menuRoles.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function listarRoles(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if (in_array('rol_index', $_SESSION['permisos'])){
                $permisosPorRol = array();
                $roles = RolesRepository::getInstance()->getRoles();
                foreach ($roles as $rol) {
                    $aux = RolesRepository::getInstance()->getPermisosPorRol($rol['id']);
                    $aux['nombreRol'] = $rol['nombre'];
                    $aux['id_rol'] = $rol['id'];
                    $permisosPorRol[$rol['nombre']] = $aux;
                }
                $parametros['permisosPorRol'] = $permisosPorRol;
                ResourceController::getInstance()->mostrarHTMLConParametros('listadoRoles.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function mostrarFormulario(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if (in_array('rol_new', $_SESSION['permisos'])){
                $parametros['permisos'] = RolesRepository::getInstance()->getPermisos();
                $parametros['titulo'] = "Nuevo rol";    
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioNuevoRol.html.twig',$parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function verificarUnicidad($nombre){
        $cant = RolesRepository::getInstance()->existeRol($nombre);
        if (count($cant) == 0) return true;
        else return false;
    }

    public function agregarNuevoRol(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if (in_array('rol_new', $_SESSION['permisos'])){
                if ($this->verificarUnicidad($_POST['nombre'])) {
                    $id = RolesRepository::getInstance()->agregarRol($_POST['nombre']);
                    if (isset($_POST['permiso'])) {
                        foreach ($_POST['permiso'] as $permiso) {
                            $param['permiso'] = $permiso;
                            $param['id'] = $id;
                            RolesRepository::getInstance()->agregarPermisoARol($param);
                        }
                    }
                    $parametros['tipo_mensaje'] = "text-success";
                    $parametros['mensaje'] = "Se ha agregado un nuevo rol";
                    $parametros['permisos'] = RolesRepository::getInstance()->getPermisos();
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioNuevoRol.html.twig',$parametros);
                }   
                else {
                    $parametros['tipo_mensaje'] = "text-danger";
                    $parametros['mensaje'] = "El nombre del rol debe ser único";
                    $parametros['permisos'] = RolesRepository::getInstance()->getPermisos();
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioNuevoRol.html.twig',$parametros);
                }
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function deleteRol(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if (in_array('rol_destroy', $_SESSION['permisos'])){
               RolesRepository::getInstance()->eliminarRol($_POST['id_rol']);
               $parametros['tipo_mensaje'] = "text-success";
               $parametros['mensaje'] = "Se ha eliminado correctamente el rol junto con sus permisos. Los
               usuarios que tenían este rol ya no lo tienen.";
               $permisosPorRol = array();
                $roles = RolesRepository::getInstance()->getRoles();
                foreach ($roles as $rol) {
                    $aux = RolesRepository::getInstance()->getPermisosPorRol($rol['id']);
                    $aux['nombreRol'] = $rol['nombre'];
                    $aux['id_rol'] = $rol['id'];
                    $permisosPorRol[$rol['nombre']] = $aux;
                }
                $parametros['permisosPorRol'] = $permisosPorRol;
                ResourceController::getInstance()->mostrarHTMLConParametros('listadoRoles.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function updateRol(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if (in_array('rol_update', $_SESSION['permisos'])){
               $parametros['nombre'] = $_POST['nombre_rol'];
               $parametros['id'] = $_POST['id_rol'];
               $parametros['titulo'] = "Editar rol";
               $parametros['permisos'] = RolesRepository::getInstance()->getPermisos();
               $permisosActuales = RolesRepository::getInstance()->getPermisosPorRol($_POST['id_rol']);
               $permisosActualesPorRol = array();
               foreach ($permisosActuales as $permisoActual) {
                   array_push($permisosActualesPorRol, $permisoActual['id']);
               }
               $parametros['permisosActualesDelRol'] = $permisosActualesPorRol;
               ResourceController::getInstance()->mostrarHTMLConParametros('formularioNuevoRol.html.twig',$parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function editarRol(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if (in_array('rol_update', $_SESSION['permisos'])){
               RolesRepository::getInstance()->updateNombreRol($_POST);
               $parametros['tipo_mensaje'] = "text-success";
               $parametros['mensaje'] = "Se actualizado el nombre del rol";
               $permisosPorRol = array();
                $roles = RolesRepository::getInstance()->getRoles();
                foreach ($roles as $rol) {
                    $aux = RolesRepository::getInstance()->getPermisosPorRol($rol['id']);
                    $aux['nombreRol'] = $rol['nombre'];
                    $aux['id_rol'] = $rol['id'];
                    $permisosPorRol[$rol['nombre']] = $aux;
                }
                $parametros['permisosPorRol'] = $permisosPorRol;
                ResourceController::getInstance()->mostrarHTMLConParametros('listadoRoles.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }
}