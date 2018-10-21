<?php
session_start();
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once('controller/ResourceController.php');
require_once('controller/SessionController.php');
require_once('controller/UserController.php');
require_once('controller/PatientController.php');
require_once('controller/ConfigurationController.php');
require_once('model/PDORepository.php');
require_once('model/UserRepository.php');
require_once('model/PatientRepository.php');
require_once('model/Resource.php');
require_once('model/ConfigurationRepository.php');
require_once('view/TwigView.php');
require_once('view/SimpleResourceList.php');
require_once('view/Home.php');

$conf = ConfigurationRepository::getInstance()->getConfiguraciones();
$_SESSION['tituloHospital'] = $conf[0]['valor'];
$_SESSION['mailContacto'] = $conf[1]['valor'];

//esto se va a modificar a los actions que tengamos 
if(!(isset($_GET["action"]))) {
    ResourceController::getInstance()->menuPrincipal('home.html.twig',array());
}elseif ($_GET["action"] == 'login'){
    ResourceController::getInstance()->mostrarHTML('login.html.twig');
}elseif ($_GET["action"] == 'inicioSesion'){
    SessionController::getInstance()->iniciarSesion();
}elseif ($_GET["action"] == 'logout'){
	SessionController::getInstance()->cerrarSesion();
}elseif($_GET["action"] == 'moduloUsuarios'){
	UserController::getInstance()->menuUsuarios('usuarios.html.twig');
}elseif($_GET["action"] == 'listarUsuarios'){
	UserController::getInstance()->getAllUsers('listaUsuarios.html.twig');
}elseif ($_GET["action"] == 'cambiarEstadoUsuario') {
	UserController::getInstance()->cambiarEstado($_POST);
}elseif ($_GET["action"] == 'moduloPacientes'){
	PatientController::getInstance()->menuPacientes('pacientes.html.twig');
}elseif ($_GET["action"] == 'listarPacientes'){
	PatientController::getInstance()->obtenerPacientes();
}elseif ($_GET["action"] == 'formularioBusquedaPaciente'){
	PatientController::getInstance()->mostrarFormulario();
}elseif ($_GET["action"] == 'buscarPaciente'){
	PatientController::getInstance()->buscarPaciente();
}elseif ($_GET["action"] == 'nuevoPacienteNN'){
	PatientController::getInstance()->crearPacienteNN();
}elseif ($_GET["action"] == 'nuevoPaciente'){
	PatientController::getInstance()->crearPaciente();
}elseif ($_GET["action"] == 'eliminarPaciente'){
	PatientController::getInstance()->eliminarPaciente();
}elseif ($_GET["action"] == 'obtenerPartidos'){
	PatientController::getInstance()->obtenerPartidos();
}elseif ($_GET["action"] == 'obtenerLocalidades'){
	PatientController::getInstance()->obtenerLocalidades();
}elseif ($_GET["action"] == 'moduloConfiguracion'){
	ConfigurationController::getInstance()->menuConfiguracion();
}elseif ($_GET["action"] == 'actualizarConfiguracion'){
	ConfigurationController::getInstance()->actualizarConfiguracion();
}else{
	ResourceController::getInstance()->mostrarHTML('error.html.twig');
}

