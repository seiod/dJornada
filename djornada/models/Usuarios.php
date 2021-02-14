<?php
class Usuarios{
    private $id;
    private $horario_id;
    private $nombre;
    private $apellidos;
    private $username;
    private $password;
    private $dni;
    private $naf;
    private $firma;
    
    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }
    
    function getId() {
        return $this->id;
    }

    function getHorario_id() {
        return $this->horario_id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getDni() {
        return $this->dni;
    }

    function getNaf() {
        return $this->naf;
    }

    function getFirma() {
        return $this->firma;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setHorario_id($horario_id): void {
        $this->horario_id = $this->db->real_escape_string($horario_id);
    }

    function setNombre($nombre): void {
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    function setApellidos($apellidos): void {
        $this->apellidos = $this->db->real_escape_string($apellidos);
    }

    function setUsername($username): void {
        $this->username = $this->db->real_escape_string($username);
    }

    function setPassword($password): void {
        $this->password = $this->db->real_escape_string($password);
    }

    function setDni($dni): void {
        $this->dni = $this->db->real_escape_string($dni);
    }

    function setNaf($naf): void {
        $this->naf = $this->db->real_escape_string($naf);
    }

    function setFirma($firma): void {
        $this->firma = $this->db->real_escape_string($firma);
    }
    
    public function save(){
        //CREAR USUARIO
        $password_encrypt = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 4]);
        $sql = "INSERT INTO usuarios VALUES(null, {$this->horario_id}, '{$this->nombre}', '{$this->apellidos}', "
        . "'{$this->username}', '{$password_encrypt}', '{$this->dni}', '{$this->naf}', '{$this->firma}');";
        $save = $this->db->query($sql);
        
        $result = false;
        
        if($save){
            $result = true;
        }
        
        return $result;
    }
    
    public function login(){
        $result = false;

        $sql = "SELECT * FROM usuarios WHERE username = '$this->username';";    
       
        $login = $this->db->query($sql);

        if($login && mysqli_num_rows($login) == 1){
            $usuario = $login->fetch_object();

            $verify = password_verify($this->password, $usuario->password);

            if($verify){
                $result = $usuario;
            }
        }
        return $result; 
    }
    
    public function update(){
        /*
         * Se construye el UPDATE de los datos del usuario.
         * Primero se setean los datos no opcionales, que pueden mostrarse en el form de actualización
         * Luego se evalua si se desea actualizar la password y la firma, en caso de hacerlo, se agrega
         * la setencia SQL para estos campos.
        */
        
        $sql = "UPDATE usuarios SET nombre = '{$this->nombre}', apellidos = '{$this->apellidos}', username = '{$this->username}', "
            . "dni = '{$this->dni}', naf = '{$this->naf}', horario_id = {$this->horario_id}";
        
        if($this->password != 'no_act'){
            $password_encrypt = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 4]);
            $sql .= " ,password = '{$password_encrypt}'";
        }
        
        if($this->firma != 'no_act'){
            $sql .= " ,firma = '{$this->firma}'";
        }
        
        $sql .= " WHERE id = ".$_SESSION['identity']->id.";";
        
        $update = $this->db->query($sql);
        
        //Variable y rutina para comprobación
        $result = false;
        if($update){
            $result = true;
        }
        
        return $result;
    }
    
    public function getOneByUser($username){
        $sql = "SELECT * FROM usuarios WHERE username = '{$username}'";
        $user = $this->db->query($sql)->fetch_object();
        
        if(!$user){
            $user = false;
        }
        
        return $user;
    }
    
    public function saveHorarioBase(){
        $horario_int = (int)$this->horario_id;
        $sql = "UPDATE usuarios SET horario_id = '{$horario_int}' WHERE id = {$_SESSION['identity']->id};";
        $query = $this->db->query($sql);
        
        return Utils::getQuery($query);
    }
    
    public function getHorarioSeleccionado(){
        $sql = "SELECT horario_id FROM usuarios WHERE id = {$_SESSION['identity']->id}";
        $query = $this->db->query($sql);
        
        return Utils::getQuery($query);
    }
}
?>