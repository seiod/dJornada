<?php
class Database{
    public static function connect(){
        $db = new mysqli('localhost', 'id16044868_administrador', 'kym-aa3W]ufL<A]a', 'id16044868_djornada_db');
        $db->query("SET NAMES 'UTF8'");
        return $db;
    }
}
?>