<?php

/**
 * Description of PatientnController
 
 */
require_once('controller/ResourceController.php');
require_once('model/SessionRepository.php');

class PatientController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function menuPacientes(){
        if (isset($_SESSION['id'])) {
            ResourceController::getInstance()->mostrarHTMLConParametros('pacientes.html.twig', $_SESSION);
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }
    
    
    
}