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
        if(isset($_POST['nombre']) && isset($_POST['contra'])) {
            $user["nombre"] = $_POST["nombre"];
            $user["contra"] = $_POST["contra"];
            $usuario = SessionRepository::getInstance()->existeUsuario($user);
            if(count($usuario)==0){
                //no existe el usuario
                $parametros['mensaje'] = "Error al iniciar sesion";
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }else{
                session_start();
                $_SESSION['nombre'] = $user['nombre'];
                var_dump($_SESSION);
                ResourceController::getInstance()->mostrarHTML('homeUsuarioLogueado.html.twig');
            }
        }
        //ResourceController::getInstance()->mostrarHTML('home.html.twig'); //parametros
    }
    
}