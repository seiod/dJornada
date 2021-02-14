<?php

class Utils {

    public static function isLogin() {
        if (!isset($_SESSION['identity'])) {
            echo "<script>window.location.href = '" . base_url . "'</script>";
            //header("Location: " . base_url);
        } else {
            return true;
        }
    }

    public static function removeDir_wf($carpeta) {
        foreach (glob($carpeta . "/*") as $archivos_carpeta) {
            if (is_dir($archivos_carpeta)) {
                rmDir_rf($archivos_carpeta);
            } else {
                unlink($archivos_carpeta);
            }
        }
        rmdir($carpeta);
    }

    public static function nameOfTheMonth($month) {
        switch ($month) {
            case '01':
                $month = 'Enero';
                break;
            case '02':
                $month = 'Febrero';
                break;
            case '03':
                $month = 'Marzo';
                break;
            case '04':
                $month = 'Abril';
                break;
            case '05':
                $month = 'Mayo';
                break;
            case '06':
                $month = 'Junio';
                break;
            case '07':
                $month = 'Julio';
                break;
            case '08':
                $month = 'Agosto';
                break;
            case '09':
                $month = 'Septiembre';
                break;
            case '10':
                $month = 'Octubre';
                break;
            case '11':
                $month = 'Noviembre';
                break;
            case '12':
                $month = 'Diciembre';
                break;
            default :
                break;
        }
        return $month;
    }

    public static function crearCarpeta($nombre) {
        $carpeta = false;
        if (!is_dir('reportes/' . $nombre)) {
            mkdir('reportes/' . $nombre, 0777, true);
            $carpeta = true;
        }
        return $carpeta;
    }

    public static function resizeImage($carpeta_nueva, $filename) {
        $foto_original = $carpeta_nueva . '/' . $filename;
        $thumb = new PHPThumb\GD($foto_original);
        $thumb->adaptiveResize(133, 50);
        $thumb->save($carpeta_nueva . '/tmp_' . $filename);
        $old_name = $carpeta_nueva . '/tmp_' . $filename;
        $resize = rename($old_name, $foto_original);

        return $resize;
    }

    public static function getQuery($query) {
        $result = false;
        if ($query){
            $result = $query;
        }
        
        return $result;
    }
    
    public static function horarioOption($id){
        switch($id){
            case 1:
                $option = '08:30 a 17:30 - Lunes a Jueves';
                break;
            
            case 2:
                $option = '09:00 a 17:30 - Lunes a Viernes';
                break;
            
            case 3:
                $option = '09:05 a 17:30 (retraso) - Lunes a Viernes';
                break;
            
            case 4:
                $option = '09:00 a 17:35 (compensación) - Lunes a Viernes';
                break;
            
            case 5:
                $option = '08:30 a 14:30 - Viernes';
                break;
            
            case 6:
                $option = '08:35 a 17:30 (retraso) - Lunes a Jueves';
                break;
            
            case 7:
                $option = '08:30 a 17:35 (compensación) - Lunes a Jueves';
                break;
            
            case 8:
                $option = '08:35 a 14:30 (retraso) - Viernes';
                break;
            
            case 9:
                $option = '08:30 a 14:35 (compensación) - Viernes';
                break;
            
            default :
                break;
        }
        
        return $option;
    }
    
    public static function ultimoDiaDelMes(){
        $dia_actual = date('d', time());
        $ultimo_dia_mes = date('d', strtotime('last day of this month', time()));
        
        /*
         * Si el ultimo dia cae fin de semana se realiza el ajuste de dia para que corresponda con el ultimo viernes de mes
         */
        if(date('l', strtotime('last day of this month', time())) == 'Saturday'){
            $ultimo_dia_mes = $ultimo_dia_mes - 1;
        }elseif(date('l', strtotime('last day of this month', time())) == 'Sunday'){
            $ultimo_dia_mes = $ultimo_dia_mes - 2;
        }
        
        $result = false;
        if($dia_actual == $ultimo_dia_mes){
            $result = true;
        }
        return $result;
    }

}

?>