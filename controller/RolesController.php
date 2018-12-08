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
}