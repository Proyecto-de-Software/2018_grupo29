<?php

/**
 * Description of ResourceRepository
 *
 * @author fede
 */

require_once('model/PDORepository.php');

class UserRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function listAll() {
        $answer = $this->queryList("select * from usuario",[]);
        return $answer;
    }

    public function getPermisos($id) {
        $answer = $this->queryList("
            SELECT p.nombre
            FROM
                usuario u
            INNER JOIN usuario_tiene_rol utr ON
                u.id = utr.usuario_id
            INNER JOIN rol r ON
                r.id = utr.rol_id
            INNER JOIN rol_tiene_permiso rtp ON
                r.id = rtp.rol_id
            INNER JOIN permiso p ON
                p.id = rtp.permiso_id
            WHERE u.id = :id",["id"=>$id]);
        return $answer;
    }

}
