<?php
/**
 * Description of PatientnController
 * @author copiarme? jamas!
 */

class APIController {

	private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function obtenerAPI($url){
    	
    	//este codigo comentado quedo de cuando usamos CURL, ahora estamos la funcion file_get_contents de php
    	/*$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;*/

		return json_decode(file_get_contents($url),true);		
    }
}