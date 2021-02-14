<?php
class HorarioBase{
    private $id;
    private $hora_entrada_matutina;
    private $hora_salida_matutina;
    private $hora_entrada_tarde;
    private $hora_salida_tarde;
    private $db;
    
    public function __construct(){
        $this->db = Database::connect();
    }
    
    function getId() {
        return $this->id;
    }

    function getHora_entrada_matutina() {
        return $this->hora_entrada_matutina;
    }

    function getHora_salida_matutina() {
        return $this->hora_salida_matutina;
    }

    function getHora_entrada_tarde() {
        return $this->hora_entrada_tarde;
    }

    function getHora_salida_tarde() {
        return $this->hora_salida_tarde;
    }

    function setId($id): void {
        $this->id = $id;
    }

    public function getHora($turno, $tipo){
        if($turno == 'matutino'){
            if($tipo == 'entrada'){
                $sql = "SELECT hora_entrada_matutina FROM horario_base WHERE id = {$this->id};";
                $query = $this->db->query($sql);
                
                return Utils::getQuery($query);
            }else{
                $sql = "SELECT hora_salida_matutina FROM horario_base WHERE id = {$this->id};";
                $query = $this->db->query($sql);
                
                return Utils::getQuery($query);
            }
        }else{
            if($tipo == 'entrada'){
                $sql = "SELECT hora_entrada_tarde FROM horario_base WHERE id = {$this->id};";
                $query = $this->db->query($sql);
                
                return Utils::getQuery($query);
            }else{
                $sql = "SELECT hora_salida_tarde FROM horario_base WHERE id = {$this->id};";
                $query = $this->db->query($sql);
                
                return Utils::getQuery($query);
            }
        }
    }
    
    public function getAllHorarios($set_id){
        $sql = "SELECT * FROM horario_base WHERE id = {$set_id};";
        $query = $this->db->query($sql);
                
        return Utils::getQuery($query);
    }
}
?>