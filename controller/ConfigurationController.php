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
        //acomodar session
        if (isset($_SESSION['id'])) { 
            if (  (in_array('configuracion_index', $_SESSION['permisos'])) or (in_array('configuracion_update', $_SESSION['permisos'])) ){
                $_SESSION['configuraciones'] = ConfigurationRepository::getInstance()->getConfiguraciones();
               // $vector['sesion'] = $_SESSION;
                ResourceController::getInstance()->mostrarHTMLConParametros('configuracion.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }

    public function actualizarConfiguracion(){
        if (isset($_SESSION['id'])) { 
            if (  (in_array('configuracion_index', $_SESSION['permisos'])) or (in_array('configuracion_update', $_SESSION['permisos'])) )
            {
                ConfigurationRepository::getInstance()->updateConfiguration($_POST);
                $this->menuConfiguracion();
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }

}