<?php
require_once 'models/Jornada.php';
require_once 'models/HorarioBase.php';
class dashboardController{
    
    /*
     * Metodo index del dashboard:
     * Verificamos que el usuario este registrado y haya iniciado sesión
     * Verificamos que no haya inicio de jornada  del día actual aun
     * Si no hay inicio de jornada, la marcamos 
     * Si todos los turnos ya estan marcados se crea la sesion que impide seguir con el marcaje del dia
     * Luego vamos preguntado en que turno se encuentra el empleado para realizar el tipo de marcaje correspondiente
     * Al final se renderizan las vistas con las variables de sesión correspondientes
     */
    public function index(){
        Utils::isLogin();
        
        //-----------------------------------------------------------------------------------------------------//
        //Creación del objeto jornada
        $jornada = new Jornada();
        $jornada->setUsuario_id($_SESSION['identity']->id);
        $jornada->setDia_mes(date("j"));
        
        //Obtención del estado del marcaje
        $status_work = $jornada->getStatus()->fetch_object();
        
        //Verificación del estado de la jornada
        if(empty($status_work->id)){
            $jornada->inicioJornada();
            unset($_SESSION['marcaje_complete']);
        }
        
        if(!empty($status_work->e_matu) && !empty($status_work->s_matu) && !empty($status_work->e_tarde) && !empty($status_work->s_tarde)){
            unset($_SESSION['working']);
            $_SESSION['marcaje_complete'] = 'Ya realizado el marcaje el día de hoy';
        }
        
        if(empty($status_work->e_matu)){
            unset($_SESSION['working']);
            $_SESSION['activar_horario_base'] = true;
            $_SESSION['turno'] = 'matutino';
        }elseif(empty($status_work->s_matu)){
            $_SESSION['working'] = true;            
            $_SESSION['turno'] = 'matutino';
        }elseif(empty($status_work->e_tarde)){
            unset($_SESSION['working']);            
            $_SESSION['turno'] = 'tarde';
        }elseif(empty($status_work->s_tarde)){
            $_SESSION['working'] = true;
            $_SESSION['turno'] = 'tarde';
            $_SESSION['ultimo_turno'] = true;
        }
        //---------------------------------------------------------------------------------------------------//
        
        //---------------------------------------------------------------------------------------------------//
        //Instanciación del horario para seleccionarlo
        $horario = new HorarioBase();
        //---------------------------------------------------------------------------------------------------//
        
        //---------------------------------------------------------------------------------------------------//
        //Renderización de vistas
        require_once 'views/dashboard/layout/cabecera.php';
        require_once 'views/dashboard/index.php';
        require_once 'views/dashboard/layout/pie.php';
        //---------------------------------------------------------------------------------------------------//
    }
    
    
    /*
     * Se verifica inicio de sesión
     * Se renderizan las vistas correspondientes a la profile page
     */
    public function profilePage(){
        Utils::isLogin();
        require_once 'views/dashboard/layout/cabecera.php';
        require_once 'views/dashboard/perfil.php';
        require_once 'views/dashboard/layout/pie.php';
    }
    
    /*
     * Se verifica inicio de sesión
     * Se renderizan las vistas correspondientes al listado de jornadas para descargar
     */
    public function showJornadas(){
        Utils::isLogin();
        require_once 'views/dashboard/layout/cabecera.php';
        require_once 'views/dashboard/jornadas.php';
        require_once 'views/dashboard/layout/pie.php';
    }
}
?>