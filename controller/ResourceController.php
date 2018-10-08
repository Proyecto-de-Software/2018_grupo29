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
    
}
