<div class="limiter">
    <div class="container-login100" style="background-image: url('<?=base_url?>assets/images/bg-01.jpg');">
        <div class="wrap-login100 p-t-30 p-b-50">
            <span class="login100-form-title p-b-41">
                    Iniciar sesión
            </span>
            <form method="POST" action="<?=base_url?>usuario/login" class="login100-form validate-form p-b-33 p-t-5">

                <div class="wrap-input100 validate-input" data-validate = "Ingresa el usuario">
                    <input class="input100" type="text" name="username" placeholder="Nombre de usuario">
                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Ingresa la contraseña">
                    <input class="input100" type="password" name="password" placeholder="Contraseña">
                    <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                </div>

                <div class="container-login100-form-btn m-t-32">
                    <button class="login100-form-btn">
                        Entrar
                    </button>
                </div>
                
                <?php if(isset($_SESSION['error_login'])):?>
                    <div class="error-login">
                        <p>
                            <?=$_SESSION['error_login'];?>
                        </p>                    
                    </div>
                <?php endif; ?>
                
                <?php 
                    //Borrado de la sesión de error login
                    if(isset($_SESSION['error_login'])){
                        unset($_SESSION['error_login']);
                        $_SESSION['error_login'] = null;
                    }                
                ?>

            </form>
        </div>
    </div>
</div>	

<div id="dropDownSelect1"></div>