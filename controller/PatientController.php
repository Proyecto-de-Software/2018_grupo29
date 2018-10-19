<?php

/**
 * Description of PatientnController
 
 */
require_once('controller/ResourceController.php');
require_once('model/SessionRepository.php');
require_once('model/PatientRepository.php');

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

    public function obtenerPacientes(){
        if (isset($_SESSION['id'])) { 
            $_SESSION['pacientes'] = PatientRepository::getInstance()->getPacientes();
            ResourceController::getInstance()->mostrarHTMLConParametros('listadoPacientes.html.twig', $_SESSION);
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }    

    public function mostrarFormulario(){
        if (isset($_SESSION['id'])) { 
            $_SESSION['historiaClinicaRandom'] = rand(1, 999999);
            if (isset($_SESSION['noHubo'])){
                if ($_SESSION['noHubo'] == 1) {
                    $_SESSION['mensaje'] = 'No se ha encontrado ningún paciente con esos datos.';
                }
            }
            else
            {
                $_SESSION['mensaje'] = '';
            }
            ResourceController::getInstance()->mostrarHTMLConParametros('busquedaPaciente.html.twig', $_SESSION);
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function buscarPaciente(){
        if (isset($_SESSION['id'])) {
            if ($_POST['nombre'] != NULL) {$parametro['nombre'] = $_POST['nombre'];}
            else {$parametro['nombre'] = '';}
            if ($_POST['apellido'] != NULL) {$parametro['apellido'] = $_POST['apellido'];}
            else {$parametro['apellido'] = '';}
            if ($_POST['nombre_tipo_documento'] != NULL) {$parametro['nombre_tipo_documento'] = $_POST['nombre_tipo_documento'];}
            else {$parametro['nombre_tipo_documento'] = '';}
            if ($_POST['numero_documento'] != NULL) {$parametro['numero_documento'] = $_POST['numero_documento'];}
            else {$parametro['numero_documento'] = '';}
            if ($_POST['nro_historia_clinica'] != NULL) {$parametro['nro_historia_clinica'] = $_POST['nro_historia_clinica'];}
            else {$parametro['nro_historia_clinica'] = '';} 
            $resultado = PatientRepository::getInstance()->buscarPaciente($parametro);
            if (count($resultado)==0){
                $_SESSION['noHubo'] = 1;;
                $this->mostrarFormulario();
            }
            else {
                if (isset($_SESSION['noHubo'])) unset($_SESSION['noHubo']);
                $_SESSION['pacientes'] = $resultado;
                ResourceController::getInstance()->mostrarHTMLConParametros('listadoPacientes.html.twig', $_SESSION);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }
    
}