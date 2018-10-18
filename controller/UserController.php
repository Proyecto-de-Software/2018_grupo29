<?php

/**
 * Description of ResourceController
 *
 * @author fede
 */


class UserController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function getAllUsers($html){
    	$users = UserRepository::getInstance()->listAll();
    }
}