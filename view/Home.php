<?php

/**
 * Description of SimpleResourceList
 *
 * @author fede
 */


class Home extends TwigView {
    
    public function show($html) {
        
        echo self::getTwig()->render($html);
          
    }

    public function showParametros($html,$datos){

    	echo self::getTwig()->render($html,array("datos"=>$datos));
    }
}
