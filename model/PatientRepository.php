<?php

/**
 * Description of PatientRepository
 *
 * @author fer
 */

require_once('model/PDORepository.php');

class PatientRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function getPacientes() {
        $answer = $this->queryList("
            SELECT
            *
            FROM
                paciente p
            INNER JOIN genero g ON
                g.id = p.genero_id
            ORDER BY p.apellido, p.nombre"
            ,[]);
        return $answer;
    }

    public function buscarPaciente($datos){
        $answer = $this->queryList("
            SELECT
            *
            FROM
                paciente p
            INNER JOIN genero g ON
                g.id = p.genero_id
            WHERE 
                p.nombre LIKE CONCAT('%', :nombre, '%') AND
                p.apellido LIKE CONCAT('%', :apellido, '%') AND
                p.tipo_doc_id LIKE CONCAT('%', :tipo_doc, '%') AND
                p.numero LIKE CONCAT('%', :numero_documento, '%') AND
                p.nro_historia_clinica LIKE CONCAT('%', :nro_historia_clinica ,'%')",
            ["nombre" => $datos['nombre'],
             "apellido" => $datos['apellido'],
             "tipo_doc" => $datos['nombre_tipo_documento'],
             "numero_documento" => $datos['numero_documento'],
             "nro_historia_clinica" => $datos['nro_historia_clinica']
            ]);
        return $answer;
    }
    
    public function crearPacienteNN($datos) {
        $answer = $this->queryList("INSERT INTO `paciente` (`id_paciente`, `apellido`, `nombre`, `fecha_nac`, `lugar_nac`, `localidad_id`, `region_sanitaria_id`, `domicilio`, `genero_id`, `tiene_documento`, `tipo_doc_id`, `numero`, `tel`, `nro_historia_clinica`, `nro_carpeta`, `obra_social_id`) VALUES (NULL, 'NN', '', '', NULL, '1', '1', '', '1', '0', '1', '', '', :nro_historia_clinica, NULL, '1')",["nro_historia_clinica" => $datos['historiaClinicaRandom']]);
        return $answer;
    }

    public function getHistoriasClinicas() {
        $answer = $this->queryList("SELECT nro_historia_clinica FROM getPacientes",[]);
        return $answer;
    }

    public function eliminarPaciente($id) {
        $this->queryList("DELETE FROM consulta WHERE paciente_id = :id",["id" => $id]);
        $this->queryList("DELETE FROM paciente WHERE id_paciente = :id",["id" => $id]);
    }

    /*public function obtenerRegionSanitaria($datos){
        $answer = $this->queryList("SELECT region_sanitaria_id FROM partido WHERE id=:id",["id" => $datos]);
        return $answer[0];
    }

    public function getPartidos(){
        $answer = $this->queryList("SELECT id, nombre FROM partido",[]);
        return $answer;
    }

    public function getLocalidades($idPartido) {
        $answer = $this->queryList("SELECT id, nombre_localidad FROM localidad WHERE partido_id = :id",["id" => $idPartido['id_partido']]);
        return $answer;
    }*/

    public function crearPaciente($datos) {
        $answer = $this->queryDevuelveId("INSERT INTO paciente (apellido, nombre, fecha_nac, lugar_nac, localidad_id, region_sanitaria_id, domicilio, genero_id, tiene_documento, tipo_doc_id, numero, tel, nro_historia_clinica, nro_carpeta, obra_social_id) VALUES ( :apellido, :nombre, :fecha, :partido, :localidad, :region_sanitaria , :domicilio, :genero_id, :tiene_documento, :tipo_documento_id, :numero , :tel, :nro_historia_clinica, :nro_carpeta, :obra_social_id);"

        ,[
            "apellido" => $datos['apellido'],
            "nombre" => $datos['nombre'],
            "fecha" => $datos['fecha_nac'],
            "localidad" => $datos['localidades'],
            "domicilio" => $datos['domicilio'],
            "genero_id" => $datos['genero_id'],
            "tiene_documento" => $datos['tiene_documento'],
            "tipo_documento_id" => $datos['tipo_documento'],
            "numero" => $datos['numero'],
            "tel" => $datos['tel'],
            "nro_historia_clinica" => $datos['nro_historia_clinica'],
            "nro_carpeta" => $datos['nro_carpeta'],
            "obra_social_id" => $datos['obra_social_id'],
            "region_sanitaria" => $datos['region_sanitaria_id'],
            "partido" => $datos['partidos']
        ]);
        return $answer;
    }

    public function datosPaciente($id){
        $answer = $this->queryList("SELECT * FROM paciente where id_paciente=:id", ["id" => $id]);
        return $answer[0];
    }

    public function actualizarPaciente($datos){
        $this->queryList("UPDATE paciente set nombre=:nombre, apellido=:apellido, domicilio=:domicilio, localidad_id=:localidad, tiene_documento=:tieneDoc, obra_social_id=:obraSoc, genero_id=:genero, tipo_doc_id=:tipoDoc, fecha_nac=:fecha, numero=:nro, nro_historia_clinica=:nroHC, nro_carpeta=:nroC, tel=:tel WHERE id_paciente=:id"
            ,[
                "nombre" => $datos["nombre"],
                "apellido" => $datos["apellido"],
                "domicilio" => $datos["domicilio"],
                "localidad" => $datos["localidades"],
                "tieneDoc" => $datos["tiene_documento"],
                "obraSoc" => $datos["obra_social_id"],
                "genero" => $datos["genero_id"],
                "tipoDoc" => $datos["tipo_documento"],
                "fecha" => $datos["fecha_nac"],
                "nro" => $datos["numero"],
                "nroHC" => $datos["nro_historia_clinica"],
                "nroC" => $datos["nro_carpeta"],
                "tel" => $datos["tel"],
                "id" => $datos["id_paciente"],
            ]);
    }

    public function unicidadNroHistoriaClinica($numero,$id) {
        $answer = $this->queryList("SELECT nro_historia_clinica FROM paciente WHERE nro_historia_clinica = :nro and id_paciente != :id",[
            "nro" => $numero, "id" => $id]);
        return $answer;
    }

    public function unicidadNroCarpeta($numero,$id) {
        $answer = $this->queryList("SELECT nro_carpeta FROM paciente WHERE nro_carpeta = :nro and id_paciente != :id",[
            "nro" => $numero, "id" => $id]);
        return $answer;
    }

    public function getMotivos(){
        $answer = $this->queryList("SELECT * FROM motivo_consulta",[]);
        return $answer;
    }

    public function getConsultas($id){
        $answer = $this->queryList("
            SELECT c.id, c.fecha, c.articulacion_con_instituciones, c.internacion, c.diagnostico, c.observaciones, a.nombre_acompanamiento, mc.nombre, tm.nombre_tratamiento FROM consulta c 
            INNER JOIN motivo_consulta mc ON c.motivo_id = mc.id 
            INNER JOIN acompanamiento a ON c.acompanamiento_id = a.id 
            INNER JOIN tratamiento_farmacologico tm ON c.tratamiento_farmacologico_id = tm.id
            WHERE paciente_id = :id"

            ,["id" => $id]);
        return $answer;
    }

    public function agregarConsulta($datos) {
        $this->queryList("
            INSERT INTO `consulta` (`id`, `paciente_id`, `fecha`, `motivo_id`, `derivacion_id`, `articulacion_con_instituciones`, `internacion`, `diagnostico`, `observaciones`, `tratamiento_farmacologico_id`, `acompanamiento_id`)
            VALUES (NULL, :id_paciente, :fecha , :id_motivo, '1', :articulacion, :internacion, :diagnostico, :observaciones, :tratamiento, :acompanamiento)"
            ,[
                "id_paciente" => $datos['id_paciente'],
                "fecha" => $datos['fecha'],
                "id_motivo" => $datos['id_motivo'],
                "articulacion" => $datos['articulacion'],
                "diagnostico" => $datos['diagnostico'],
                "observaciones" => $datos['observaciones'],
                "tratamiento" => $datos['tratamiento_farmacologico'],
                "acompanamiento" => $datos['acompanamiento'],
                "internacion" => $datos['internacion']
            ]);
    }

    public function getConsulta($id){
        $answer = $this->queryList("
            SELECT c.id, c.fecha, c.motivo_id, c.tratamiento_farmacologico_id, c.articulacion_con_instituciones, c.internacion, c.diagnostico, c.observaciones, a.nombre_acompanamiento, mc.nombre, tm.nombre_tratamiento, p.nombre as nombre_paciente, p.apellido
            FROM consulta c 
            INNER JOIN motivo_consulta mc ON c.motivo_id = mc.id 
            INNER JOIN acompanamiento a ON c.acompanamiento_id = a.id 
            INNER JOIN tratamiento_farmacologico tm ON c.tratamiento_farmacologico_id = tm.id
            INNER JOIN paciente p ON c.paciente_id = p.id_paciente
            WHERE c.id = :id"

            ,["id" => $id]);
        return $answer;
    }

    public function updateConsulta($datos) {
        $answer = $this->queryList("
            UPDATE `consulta` 
            SET fecha = :fecha ,
            motivo_id = :motivo_id ,
            articulacion_con_instituciones = :articulacion ,
            internacion = :internacion ,
            diagnostico = :diagnostico ,
            observaciones = :observaciones ,
            tratamiento_farmacologico_id = :tratamiento ,
            acompanamiento_id = :acompanamiento
            WHERE `consulta`.`id` = :id_consulta

            ",[
                "fecha" => $datos['fecha'],
                "motivo_id" => $datos['motivo'],
                "articulacion" => $datos['articulacion'],
                "internacion" => $datos['internacion'],
                "diagnostico" => $datos['diagnostico'],
                "observaciones" => $datos['observaciones'],
                "tratamiento" => $datos['tratamiento_farmacologico'],
                "acompanamiento" => $datos['acompanamiento'],
                "id_consulta" => $datos['id_consulta']
            ]);
        return $answer;
    }

    public function deleteConsulta($id) {
        $this->queryList("DELETE FROM consulta WHERE id = :id",["id" => $id]);
    }
}










