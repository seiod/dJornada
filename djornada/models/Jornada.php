<?php
class Jornada{
    //Atributos de la entidad Jornada
    private $id;
    private $usuario_id;
    private $dia_mes;
    private $e_matu;
    private $s_matu;
    private $e_tarde;
    private $s_tarde;
    private $db;
    
    /*construct method*/
    public function __construct() {
        $this->db = Database::connect();
    }
    
    /*Getters and setters*/
    function getId() {
        return $this->id;
    }

    function getUsuario_id() {
        return $this->usuario_id;
    }

    function getDia_mes() {
        return $this->dia_mes;
    }

    function getE_matu() {
        return $this->e_matu;
    }

    function getS_matu() {
        return $this->s_matu;
    }

    function getE_tarde() {
        return $this->e_tarde;
    }

    function getS_tarde() {
        return $this->s_tarde;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setUsuario_id($usuario_id): void {
        $this->usuario_id = $usuario_id;
    }

    function setDia_mes($dia_mes): void {
        $this->dia_mes = $dia_mes;
    }

    function setE_matu($e_matu): void {
        $this->e_matu = $e_matu;
    }

    function setS_matu($s_matu): void {
        $this->s_matu = $s_matu;
    }

    function setE_tarde($e_tarde): void {
        $this->e_tarde = $e_tarde;
    }

    function setS_tarde($s_tarde): void {
        $this->s_tarde = $s_tarde;
    }
    
    /*Methods:*/

    /*
     * getStatus arroja toda la información actual de la jornada para un usuario y día específico
     */
    public function getStatus(){
        $sql = "SELECT * FROM jornada_general WHERE usuario_id = {$this->usuario_id} and dia_mes = '{$this->dia_mes}';";
        $query = $this->db->query($sql);
        
        $result = false;
        if($query){
            $result = $query;
        }
        
        return $result;
    }
    
    /*
     * inicioJornada marca el inicio de la jornada cuando el usuario marca el primer fichaje del día
     * Inserta en la tabla la hora para e_matu en que el usuario identificado marca la entrada matutina
     */
    public function inicioJornada(){
        $sql = "INSERT INTO jornada_general VALUES(null, '{$this->usuario_id}', '{$this->dia_mes}', '', '', '', '');";
        $query = $this->db->query($sql);
        
        $result = false;
        if($query){
            $result = true;
        }
        
        return $result;
    }
        
    /*
     *updateJornada actualiza el turno en el que se encuentra el usuario, marcando la hora específica del sistema del día actual 
     */
    public function updateJornada($turno, $hora){
        $sql = "UPDATE jornada_general SET $turno = '{$hora}' WHERE usuario_id = $this->usuario_id and dia_mes = '{$this->dia_mes}';";
        $query = $this->db->query($sql);
        
        $result = false;
        if($query){
            $result = true;
        }
        
        return $result;
    }
    
    /*
     * getAllByUserAndDay devuelve toda la información de la joranda para un usuario y día específico
     */
    public function getAllByUserAndDay(){
        $sql = "SELECT * FROM jornada_general WHERE usuario_id = $this->usuario_id and dia_mes = '{$this->dia_mes}';";
        $query = $this->db->query($sql);
        
        $result = false;
        if($query){
            $result = $query;
        }
        
        return $result;
    }
}
?>