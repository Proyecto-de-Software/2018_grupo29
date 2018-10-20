<?php
session_start();
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once('controller/ResourceController.php');
require_once('controller/SessionController.php');
require_once('controller/UserController.php');
require_once('controller/PatientController.php');
require_once('model/PDORepository.php');
require_once('model/UserRepository.php');
require_once('model/PatientRepository.php');
require_once('model/Resource.php');
require_once('view/TwigView.php');
require_once('view/SimpleResourceList.php');
require_once('view/Home.php');

//esto se va a modificar a los actions que tengamos 
if(!(isset($_GET["action"]))) {
    ResourceController::getInstance()->menuPrincipal('home.html.twig',array());
}elseif ($_GET["action"] == 'login'){
    ResourceController::getInstance()->mostrarHTML('login.html.twig');
}elseif ($_GET["action"] == 'inicioSesion'){
    SessionController::getInstance()->iniciarSesion();
}elseif ($_GET["action"] == 'logout'){
	SessionController::getInstance()->cerrarSesion();
}elseif($_GET["action"] == 'listarUsuarios'){
	UserController::getInstance()->getAllUsers('listaUsuarios.html.twig');
}elseif ($_GET["action"] == 'moduloPacientes'){
	PatientController::getInstance()->menuPacientes('pacientes.html.twig');
}elseif ($_GET["action"] == 'listarPacientes'){
	PatientController::getInstance()->obtenerPacientes();
}elseif ($_GET["action"] == 'formularioBusqueda'){
	PatientController::getInstance()->mostrarFormulario();
}elseif ($_GET["action"] == 'buscarPaciente'){
	PatientController::getInstance()->buscarPaciente();
}elseif ($_GET["action"] == 'nuevoPacienteNN'){
	PatientController::getInstance()->crearPacienteNN();
}elseif ($_GET["action"] == 'nuevoPaciente'){
	PatientController::getInstance()->crearPaciente();
}else{
	ResourceController::getInstance()->mostrarHTML('error.html.twig');
}

