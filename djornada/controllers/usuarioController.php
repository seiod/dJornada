<?php
require_once 'models/Usuarios.php';
class usuarioController{
    
    /*
     * Renderizamos la login page con su formulario
     */
    public function index(){
        require_once 'views/usuario/login.php';
    }
    
    /*
     * Metodo para crear usuario
     * De momento (11/01/2021) no esta habilitado para el usuario, con lo cual:
     * Se setea el modelo, se guarda el usuario en la BBDD y se crea una carpeta para los reportes
     */
    public function save(){
//        if(isset($_POST)){
//            
//            $horario = isset($_POST['horario']) ? $_POST['horario'] : false;
//            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
//            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
//            $username = isset($_POST['username']) ? $_POST['username'] : false;
//            $password = isset($_POST['password']) ? $_POST['password'] : false;
//            $dni = isset($_POST['dni']) ? $_POST['dni'] : false;
//            $naf = isset($_POST['naf']) ? $_POST['naf'] : false;
//            $firma = isset($_POST['firma']) ? $_POST['firma'] : false;
//            
//            if($nombre && $apellidos && $username && $password){
                $usuario = new Usuarios();
                $usuario->setHorario_id(1);//$horario);
                $usuario->setNombre("Julio");//($nombre);
                $usuario->setApellidos("Siavichay");//($apellidos);
                $usuario->setUsername("Julio");//($username);
                $usuario->setPassword("1234");//($password);
                $usuario->setDni("34f575R");//($dni);
                $usuario->setNaf("85746372574");//($naf);
                $usuario->setFirma("");//($firma);
                
                $save = $usuario->save();
                $carpeta = Utils::crearCarpeta($usuario->getUsername());
                if($save && $carpeta){
                    $_SESSION['register'] = 'complete';                    
                }else{
                    $_SESSION['register'] = 'failed';
                }
////            }else{
////                $_SESSION['register'] = 'failed';
////            }
////        }else{
////            $_SESSION['register'] = 'failed';
//        }
        echo "<script>window.location.href = '" . base_url . "'</script>";
        //header("Location: ".base_url);
    } 
    
    
    /*
     * Se verifica que el array POST no venga vacio
     * Se validan los datos del formulario de inicio de sesión
     * Se crea la sesion para el usuario indicado
     */
    public function login(){          
        //Reconocimiento de datos via POST
        if(isset($_POST)){
            //Recepción de datos del form
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            //-----------------------------------------------------------------------------------//
            
            //Validación de los datos recibidos por POST
            if(is_string($username)){
                $username = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['username']);
                $username = filter_var($username, FILTER_SANITIZE_STRING);
            }
            
            if(is_string($password)){
                $password = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['password']);
                $password = filter_var($password, FILTER_SANITIZE_STRING);
            }
            //-----------------------------------------------------------------------------------//
            
            //Creación del objeto usuario
            $usuario = new Usuarios();
            
            //Seteo de atributos de usuario
            $usuario->setUsername($username);
            $usuario->setPassword($password);
            
            //Verificación y solicitud de datos de usuario
            $identity = $usuario->login();
    
            //Crear sesion
            if($identity && is_object($identity)){
                $_SESSION['identity'] = $identity;
            }else{
                $_SESSION['error_login'] = 'identificación fallida';
                echo "<script>window.location.href = '" . base_url . "'</script>";
            }
        }
        //header("Location: ".base_url."dashboard/index");
        echo "<script>window.location.href = '" . base_url . "dashboard/index'</script>";
    }
    
    /*
     * Se verifica inicio de sesión
     * Se elimina la sesión de usuario 'identity'
     */
    public function logout(){
        Utils::isLogin();
        unset($_SESSION['identity']);
        $_SESSION['identity'] = null;
        echo "<script>window.location.href = '" . base_url . "'</script>";
        //header("Location: ".base_url);
    }   
    
    public function update(){
        Utils::isLogin();
        if(isset($_POST)){
            //Recepción de datos POST
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
            $naf = isset($_POST['naf']) ? $_POST['naf'] : '';
            $horario = isset($_POST['horario']) ? $_POST['horario'] : '';
            $firma = isset($_FILES['firma']) ? $_FILES['firma'] : '';
            //=============================================================================================//
            
            //=============================================================================================//
            //Array de errores
            $data_errors = array();
            
            //Validación de los datos recibidos por POST
            if(is_string($nombre) && !empty($nombre)){
                $nombre = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['nombre']);
                $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
            }else{
                $data_errors['nombre'] = 'bad name'; 
            }
            
            if(is_string($apellidos) && !empty($apellidos)){
                $apellidos = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['apellidos']);
                $apellidos = filter_var($apellidos, FILTER_SANITIZE_STRING);
            }else{
                $data_errors['apellidos'] = 'bad lastname'; 
            }
            
            if(is_string($username) && !empty($username)){
                $username = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['username']);
                $username = filter_var($username, FILTER_SANITIZE_STRING);
            }else{
                $data_errors['username'] = 'bad username'; 
            }
            
            if(is_string($password) && !empty($password)){
                $password = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['password']);
                $password = filter_var($password, FILTER_SANITIZE_STRING);
            }elseif(empty ($password)){
                $password = 'no_act';
            }else{
                $data_errors['password'] = 'bad password'; 
            }
            
            if(is_string($dni) && !empty($dni)){
                $dni = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['dni']);
                $dni = filter_var($dni, FILTER_SANITIZE_STRING);
            }else{
                $data_errors['dni'] = 'bad dni'; 
            }
            
            if(is_string($naf) && !empty($naf)){
                $naf = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['naf']);
                $naf = filter_var($naf, FILTER_SANITIZE_STRING);
            }else{
                $data_errors['naf'] = 'bad naf'; 
            }
            
            if(is_string($horario)){
                $horario = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['horario']);
                $horario = filter_var($horario, FILTER_SANITIZE_NUMBER_INT);
            }else{
                $data_errors['horario'] = 'bad horario'; 
            }
            
            if(empty($firma['name'])){
                $firma['name'] = 'no_act';
            }
            //===========================================================================================//
            
            //===========================================================================================//
            if(sizeof($data_errors) == 0){
                //Instanciación de la clase usuario
                $usuario = new Usuarios();
            
                //Setear el modelo
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setUsername($username);
                $usuario->setPassword($password);
                $usuario->setDni($dni);
                $usuario->setNaf($naf);
                $usuario->setHorario_id($horario);
                
                //En caso de cambio de username, eliminar la antigua carpeta y apuntar a la nueva
                if($_SESSION['identity']->username != $username){
                    //Carpeta de firma
                    $carpeta_antigua = 'uploads/firmas/'.$_SESSION['identity']->username;
                    $carpeta_nueva = 'uploads/firmas/'.$username;
                    rename($carpeta_antigua, $carpeta_nueva);     
                    
                    //Carpeta de report's
                    $carpeta_antigua = 'reportes/'.$_SESSION['identity']->username;
                    $carpeta_nueva = 'reportes/'.$username;
                    rename($carpeta_antigua, $carpeta_nueva);
                }
                
                //Guardar la firma
                if($firma['name'] != 'no_act'){
                    $filename = $firma['name'];
                    $mimetype = $firma['type'];

                    if($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gift'){
                        $carpeta_antigua = 'uploads/firmas/'.$_SESSION['identity']->username;
                        $carpeta_nueva = 'uploads/firmas/'.$username;

                        if(!is_dir($carpeta_nueva)){
                            mkdir($carpeta_nueva, 0777, true);
                        }

                        if(!is_null($filename)){                                                        
                            move_uploaded_file($firma['tmp_name'], $carpeta_nueva.'/'.$filename);
                            
                            $resize = Utils::resizeImage($carpeta_nueva, $filename);
                            if($resize){
                                $usuario->setFirma($filename);
                            }
                        }
                    }          
                }else{
                    $usuario->setFirma($firma['name']);
                }
                
                $edit = $usuario->update();
                
                if($edit){
                    $_SESSION['update_ok'] = 'Actualización grabada correctamente';
                }else{
                    $_SESSION['update_bad'] = 'No se pudo actualizar, revise los datos';
                }                    
            }else{
                $_SESSION['update_bad'] = 'No se pudo actualizar, revise los datos';
            }  
        }
        //Actualizar sesión
        $_SESSION['identity'] = $usuario->getOneByUser($username);
        echo "<script>window.location.href = '" . base_url . "dashboard/profilePage'</script>";
        //header("Location: ".base_url.'dashboard/profilePage');
    }
}
?>