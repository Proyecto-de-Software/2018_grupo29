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
    
    
    public function login(){
        $view = new Home();
        $view->show('login.html.twig');
    }
    
    public function home(){
        $view = new Home();
        $view->show('home.html.twig');
    }
    
}
