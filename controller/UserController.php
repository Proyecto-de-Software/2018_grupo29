<?php

/**
 * Description of ResourceController
 *
 * @author fede
 */
require_once('controller/ResourceController.php');
require_once('model/SessionRepository.php');
require_once('model/UserRepository.php');

class UserController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function menuUsuarios(){
        if (isset($_SESSION['id'])) { 
            if ( 
                (in_array('usuario_show', $_SESSION['permisos'])) or 
                (in_array('usuario_new', $_SESSION['permisos'])) or 
                (in_array('usuario_update', $_SESSION['permisos'])) or
                (in_array('usuario_index', $_SESSION['permisos'])) or 
                (in_array('usuario_destroy', $_SESSION['permisos']))
                 ){
                ResourceController::getInstance()->mostrarHTMLConParametros('usuarios.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function getAllUsers($html){
    	$_SESSION["usuarios"] = UserRepository::getInstance()->listAll();
        ResourceController::getInstance()->mostrarHTMLConParametros($html,$_SESSION);
    	//galletita con paginas
    	//array_chunk magico

    }

    public function obtenerPermisos($id){
    	$permisos = UserRepository::getInstance()->getPermisos($id);
    	$vectorPermisos = array();
    	foreach ($permisos as $elemento){
    		array_push($vectorPermisos, $elemento["nombre"]);
    	}
    	return $vectorPermisos;	
    }

    public function cambiarEstado($datos){
        if($datos["usuario_estado"]==0){
            $datosNuevos["usuario_estado"] = 1;
            $datosNuevos["usuario_id"] = $datos["usuario_id"];
            UserRepository::getInstance()->cambiarEstado($datosNuevos);
        }else{
            $datosNuevos["usuario_estado"] = 0;
            $datosNuevos["usuario_id"] = $datos["usuario_id"];
            UserRepository::getInstance()->cambiarEstado($datosNuevos);
        }
        $this->getAllUsers('listaUsuarios.html.twig');
    }
}