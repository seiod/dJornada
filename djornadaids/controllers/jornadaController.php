<?php
require_once 'models/Jornada.php';
require_once 'models/HorarioBase.php';
require_once 'models/Usuarios.php';
class jornadaController{
    
    /*
     * Esta función se activa cada vez que el usuario pulsa el botón de marcaje, sea para entrada o salida
     * Se valida el inicio de sesión
     * Se verifica que no venga vacio el array POST
     * No se validan datos ya que no son modificables por el usuario, lo unico seleccionable es el tipo de horario
     * Se comprueba que el usuario tenga firma creada antes de marcar
     * Se valida luego el tipo de horario seleccionado, tiempo real o hora de e/s definida
     * Se verifica el turno matutino o tarde y la entrada o salida y se procede a hacer el marcaje correspondiente
     * Tanto si el marcaje sale bien o no se notifica al usuario el status
     * 
     * Para horarios definidos, se capta el tipo de horario = horario_definido y a partir de ahi se guarda el id
     * del horario (variable hora_base) en el modelo del usuario y este a la BBDD (saveHorarioBase) para persistencia, ya que un horario
     * seleccionado debe permanecer durante todo el dia. Luego el id del horario se recupera desde el modelo con
     * getHorarioSeleccionado, para así setear la jornada_general con la hora seleccionada
     * 
     * "Evento" para generar el report mensual
     * El sistema verifica continuamente si nos encontramos en el ultimo dia de mes y si hemos realizado el ultimo marcaje
     * En caso de suceder esto, se verifica que el usuario tenga carpeta de reportes del año en curso, sino, la crea
     * Luego se verifica si hay algun reporte ya creado del mes, sino, lo crea.
     */
    public function index(){
        Utils::isLogin();
        if(isset($_POST)){
            //=============================================================================================//
            //Verificación POST data
            $tipo_fichaje = isset($_POST['tipo_fichaje']) ? $_POST['tipo_fichaje'] : '';
            $tipo_horario = isset($_POST['tipo_horario']) ? $_POST['tipo_horario'] : '';
            $hora_base = isset($_POST['hora_base']) ? $_POST['hora_base'] : '';

            //=============================================================================================//
            if(isset($_SESSION['identity']->firma)){
                $jornada = new Jornada();
                $jornada->setDia_mes(date("j"));
                $jornada->setUsuario_id($_SESSION['identity']->id);
                if($tipo_horario == 'real_time'){
                    $hora = date("H".":"."i");
                }
                //=========================================================================================//
                
                //Variable de control de ultimo fichaje diario
                $ultimo_diario = false;
                
                //=========================================================================================//
                
                //Marcaje de entrada o salida
                if($_SESSION['turno'] == 'matutino'){
                    if($tipo_fichaje == 'entrar'){
                        if($tipo_horario == 'horario_definido'){
                            $usuario = new Usuarios();
                            $usuario->setHorario_id($hora_base);
                            $usuario->saveHorarioBase();
                            $horario_seleccionado = $usuario->getHorarioSeleccionado()->fetch_object()->horario_id;
                            
                            $horario = new HorarioBase();
                            $horario->setId($horario_seleccionado);
                            $hora = $horario->getHora('matutino', 'entrada')->fetch_object()->hora_entrada_matutina;
                        }
                        $marcaje = $jornada->updateJornada('e_matu', $hora);
                    }elseif($tipo_fichaje == 'salir'){
                        if($tipo_horario == 'horario_definido'){
                            $usuario = new Usuarios();
                            $horario_seleccionado = $usuario->getHorarioSeleccionado()->fetch_object()->horario_id;
                            
                            $horario = new HorarioBase();
                            $horario->setId($horario_seleccionado);
                            $hora = $horario->getHora('matutino', 'salida')->fetch_object()->hora_salida_matutina;
                        }
                        $marcaje = $jornada->updateJornada('s_matu', $hora);
                    }
                }elseif($_SESSION['turno'] == 'tarde'){
                    if($tipo_fichaje == 'entrar'){
                        if($tipo_horario == 'horario_definido'){
                            $usuario = new Usuarios();
                            $horario_seleccionado = $usuario->getHorarioSeleccionado()->fetch_object()->horario_id;
                            
                            $horario = new HorarioBase();
                            $horario->setId($horario_seleccionado);
                            $hora = $horario->getHora('tarde', 'entrada')->fetch_object()->hora_entrada_tarde;
                        }
                        $marcaje = $jornada->updateJornada('e_tarde', $hora);
                    }elseif($tipo_fichaje == 'salir'){
                        if($tipo_horario == 'horario_definido'){
                            $usuario = new Usuarios();
                            $horario_seleccionado = $usuario->getHorarioSeleccionado()->fetch_object()->horario_id;
                            
                            $horario = new HorarioBase();
                            $horario->setId($horario_seleccionado);
                            $hora = $horario->getHora('tarde', 'salida')->fetch_object()->hora_salida_tarde;
                        }
                        $marcaje = $jornada->updateJornada('s_tarde', $hora);
                        $ultimo_diario = true;
                    }                  
                }

                if($marcaje){
                    $_SESSION['marcaje_ok'] = 'Se ha guardado su marcaje correctamente';
                }else{
                    $_SESSION['marcaje_bad'] = 'Se ha producido un error al fichar, intentelo nuevamente';
                }
                //=========================================================================================//
            }else{
                $_SESSION['firma_bad'] = 'Actualmente no tienes firma registrada, ingresa una firma para poder marcar';
            }
        }
        
        //---------------------------------------------------------------------------------------------------//
        //Evento para generar el reporte mensual de diario de jornada
        if(Utils::ultimoDiaDelMes() && $ultimo_diario == true){               
            //El usuario tiene carpeta del año en curso?
            if(!is_dir('reportes/'.$_SESSION['identity']->username.'/'.date('Y', time()))){
                mkdir('reportes/'.$_SESSION['identity']->username.'/'.date('Y', time()), 0777, true);
            }
            
            //El usuario tiene report del mes en curso?
            if(!is_file('reportes/'.$_SESSION['identity']->username.'/'.date('Y', time()).'/'.date('m-Y', time()).'.pdf')){
                $this->reporteMensual();
            }
        }
        //---------------------------------------------------------------------------------------------------//
        
        echo "<script>window.location.href = '" . base_url . "dashboard/index'</script>";
        //header("Location: ".base_url.'dashboard/index');
    }
    
    /*
     * Validamos el inicio de sesión
     * Rellenamos variables con datos necesarios para el reporte, ver: modelo de reporte
     * Seteamos el modelo de Jornada con el usuario a crear el report
     * Rellenamos la plantilla con los datos recuperados
     * Guardamos la plantilla en la var $html
     * Hacemos uso de la libreria Html2Pdf para generar el report en formato PDF
     * Guardamos el PDF generado en la carpeta del usuario para año y mes en curso
     */
    public function reporteMensual(){
        Utils::isLogin();        
        //============================================================================================//
        //Datos para el reporte

        //Datos de empresa
        $empresa = 'IDS SOPORTE Y ASISTENCIA TECNICA, S.L.';
        $cif = 'B63332159';
        $cuenta_cotizacion = '8142385720';

        //Datos del trabajador
        $username = $_SESSION['identity']->username;
        $nombre = $_SESSION['identity']->nombre;
        $apellidos = $_SESSION['identity']->apellidos;
        $dni = $_SESSION['identity']->dni;
        $naf = $_SESSION['identity']->naf;

        //Recuperar datos de la jornada mensual
        $jornada = new Jornada();
        $jornada->setUsuario_id($_SESSION['identity']->id);

        //Rellenar reporte
        ob_start();
        require_once 'reportes/plantilla.php';
        $html = ob_get_clean();
        ob_end_clean();
        
        //generar PDF/
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
        $html2pdf->writeHTML($html);      
       
        //Guardar en carpeta de usuario   
        $dir = str_replace('controllers', '', __DIR__);
        $html2pdf->output($dir.'reportes\\'.$username.'\\'.date('Y', time()).'\\'.date('m-Y', time()).'.pdf', 'F');
    }
}
?>