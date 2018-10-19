<?php

/**
 * Description of ResourceController
 *
 * @author fede
 */


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

    public function getAllUsers($html){
    	$users = UserRepository::getInstance()->listAll();
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
    	/*$permisos["pacientes"] = UserRepository::getInstance()->getPermisos($id,"paciente");
    	$permisos["usuarios"] = UserRepository::getInstance()->getPermisos($id,"usuario");
    	$permisos["roles"] = UserRepository::getInstance()->getPermisos($id,"rol");
    	$permisos["permisos"] = UserRepository::getInstance()->getPermisos($id,"permiso");
    	$permisos["configuracion"] = UserRepository::getInstance()->getPermisos($id,"configuracion");
    	$permisos["consultas"] = UserRepository::getInstance()->getPermisos($id,"consulta");
    	if(count($permisos["pacientes"])!==0){
    		$botonesACrear["pacientes"]='botonPacientes.html.twig';
    		if(in_array("paciente_index", $permisos["pacientes"][0], true)){
    			$botonesACrear["pacientes_index"]='pacientesListado.html.twig';
    		}
    		if(in_array("paciente_search", $permisos["pacientes"][1])){
    			$botonesACrear["pacientes_search"]='pacientesBusqueda.html.twig';
    		}
    		if(in_array("paciente_new", $permisos["pacientes"][2])){
    			$botonesACrear["pacientes_new"]='pacientesCreacion.html.twig';
    		}
    	}
    	if(count($permisos["consultas"])!==0){
    		$botonesACrear["consultas"]='botonConsultas.html.twig';
    	}
    	if((count($permisos["usuarios"])!==0)or (count($permisos["roles"])!==0) or (count($permisos["permisos"])!==0) or (count($permisos["configuracion"])!==0)){
    		$botonesACrear["administracion"]='botonAdministracion.html.twig';
	    	if(count($permisos["usuarios"])!==0){
	    		$botonesACrear["usuarios"]='botonUsuarios.html.twig';
	    	}
	    	if(count($permisos["roles"])!==0){
	    		$botonesACrear["roles"]='botonRoles.html.twig';
	    	}
	    	if(count($permisos["permisos"])!==0){
	    		$botonesACrear["permisos"]='botonPermisos.html.twig';
	    	}
	    	if(count($permisos["configuracion"])!==0){
	    		$botonesACrear["configuracion"]='botonConfiguracion.html.twig';
	    	}
	    }
    	return $botonesACrear;*/
    }
}