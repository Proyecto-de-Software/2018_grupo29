<?php

/**
 * Description of SessionController
 
 */
require_once('controller/ResourceController.php');
require_once('model/SessionRepository.php');

class SessionController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    public function iniciarSesion(){
        //en esta me parece que el session esta bien
        if(isset($_POST['nombre']) && isset($_POST['contra'])) {
            $user["nombre"] = $_POST["nombre"];
            $user["contra"] = $_POST["contra"];
            $usuario = SessionRepository::getInstance()->existeUsuario($user);
            if(count($usuario)==0){
                //no existe el usuario
                $parametros['mensaje'] = "¡Error! Nombre de usuario o contraseña incorrecto";
                ResourceController::getInstance()->mostrarHTMLConParametros('login.html.twig', $parametros);
            }
            else{
                if ($usuario[0]['activo'] == 1){
                   $parametros['mensaje'] = "Lamentablemente tu cuenta ha sido bloqueada";
                ResourceController::getInstance()->mostrarHTMLConParametros('login.html.twig', $parametros); 
                }
                else {
                    $_SESSION['nombre'] = $usuario[0]['username'];
                    $_SESSION['first_name'] = $usuario[0]['first_name'];
                    $_SESSION['id'] = $usuario[0]['id'];
                    $_SESSION['permisos'] = UserController::getInstance()->obtenerPermisos($usuario[0]['id']);
                    ResourceController::getInstance()->menuPrincipal('home.html.twig');
                }
            }
        }
        //ResourceController::getInstance()->mostrarHTML('home.html.twig'); //parametros
    }

    public function cerrarSesion(){
        if(isset($_SESSION)){
            session_unset();
            session_destroy();
            ResourceController::getInstance()->menuPrincipal('home.html.twig',array());
        }
    }
    
}