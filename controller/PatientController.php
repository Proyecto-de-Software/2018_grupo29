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
            if ( 
                (in_array('paciente_show', $_SESSION['permisos'])) or 
                (in_array('paciente_new', $_SESSION['permisos'])) or 
                (in_array('paciente_update', $_SESSION['permisos'])) or
                (in_array('paciente_index', $_SESSION['permisos'])) or 
                (in_array('paciente_destroy', $_SESSION['permisos']))
                 ){
                ResourceController::getInstance()->mostrarHTMLConParametros('pacientes.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }
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
            if (in_array('paciente_index', $_SESSION['permisos'])) {
                $historiasClinicas = PatientRepository::getInstance()->getHistoriasClinicas();
                $i = 0;
                $numerosHistoriasClinicas = array();
                foreach ($historiasClinicas as $historia) {
                    $numerosHistoriasClinicas[$i] = $historia['nro_historia_clinica'];
                    $i++;
                }
                do {
                    $numero = rand(1, 999999);
                } while (in_array($numero, $numerosHistoriasClinicas));
                $_SESSION['historiaClinicaRandom'] = $numero;
                if (isset($_SESSION['noHubo'])){
                    if ($_SESSION['noHubo'] == 1) {
                        $_SESSION['mensaje'] = 'No se ha encontrado ningún paciente con esos datos.';
                        $_SESSION['tipo_mensaje'] = 'text-danger';
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

    public function crearPacienteNN(){
        $parametro['nro_historia_clinica'] = $_SESSION['historiaClinicaRandom'];
        PatientRepository::getInstance()->crearPacienteNN($parametro);
        $_SESSION['mensaje'] = 'Se ha creado un NN con historia clínica '.$parametro['nro_historia_clinica'];
        $_SESSION['tipo_mensaje'] = 'text-success';
        $_SESSION['historiaClinicaRandom'] = 0;
        ResourceController::getInstance()->mostrarHTMLConParametros('busquedaPaciente.html.twig', $_SESSION);
    }

    public function crearPaciente() {
        if (isset($_SESSION['id'])) {
            if (in_array('paciente_new', $_SESSION['permisos'])){
                $_SESSION['listaPartidos'] = $this->obtenerPartidos();
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaPaciente.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }
    
    public function eliminarPaciente() {
        if (isset($_SESSION['id'])){
            if (in_array('paciente_destroy', $_SESSION['permisos'])){
                PatientRepository::getInstance()->eliminarPaciente($_POST['id_paciente']);
                PatientController::getInstance()->obtenerPacientes();
            }
            else {
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function obtenerPartidos() {
        if (isset($_SESSION['id'])){
            return PatientRepository::getInstance()->getPartidos();
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function obtenerLocalidades() {
        if (isset($_SESSION['id'])){
            $idLocalidad = $_POST['id_partido'];
            return PatientRepository::getInstance()->getLocalidades($idLocalidad);
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

}