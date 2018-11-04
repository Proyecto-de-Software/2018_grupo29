<?php

/**
 * Description of ConfigurationController
 *
 * @author fede
 */
require_once('controller/ResourceController.php');
require_once('model/SessionRepository.php');
require_once('model/ConfigurationRepository.php');

class ConfigurationController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function menuConfiguracion(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if (  (in_array('configuracion_index', $_SESSION['permisos'])) or (in_array('configuracion_update', $_SESSION['permisos'])) ){
                $parametros['configuraciones'] = ConfigurationRepository::getInstance()->getConfiguraciones();
               // $vector['sesion'] = $_SESSION;
                ResourceController::getInstance()->mostrarHTMLConParametros('configuracion.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function actualizarConfiguracion(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if (  (in_array('configuracion_index', $_SESSION['permisos'])) or (in_array('configuracion_update', $_SESSION['permisos'])) )
            {
                ConfigurationRepository::getInstance()->updateConfiguration($_POST);
                $this->menuConfiguracion();
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