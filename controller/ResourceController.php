<?php

/**
 * Description of ResourceController
 *
 * @author fede
 */
class ResourceController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    public function mostrarHTML($html){
        $view = new Home();
        $view->show($html);
    }
    
    public function mostrarHTMLConParametros($html, $datos){
        $view = new Home();
        $view->showConParametros($html, $datos);
    }

    public function menuPrincipal($html){
        $view = new Home();
        if(isset($_SESSION['id'])){
            $user["first_name"] = $_SESSION['first_name'];
            $view->showConParametros($html,$user);
        }else{
            $view->show($html);
        }
    }
}
