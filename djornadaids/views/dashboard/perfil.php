<div id="main-dashboard">
    <nav class="panel-description">
        <label id="main-panel">EDITAR PERFIL</label>
    </nav>
</div>
<div class="profile-page-wrap">
    <form method="POST" action="<?=base_url?>usuario/update" enctype="multipart/form-data" class="form-profile">
        <div class="form-header-update">
            <h1>Sobre ti</h1>
            <p>Ingrese la información solicitada. Si quieres modificarla luego, podrás hacerlo aquí</p>
        </div>
        <section class="personal-data">
            <div class="data-container">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" value="<?=$_SESSION['identity']->nombre?>" pattern="[a-zA-Z ]{2,254}" required/>
            </div>
            
            <div class="data-container">
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos" value="<?=$_SESSION['identity']->apellidos?>" pattern="[a-zA-Z ]{2,254}" required/>
            </div>
            
            <div class="data-container">
                <label for="username">Usuario</label>
                <input type="text" name="username" value="<?=$_SESSION['identity']->username?>" pattern="[a-zA-Z ]{2,254}" required/>
            </div>
            
            <div class="data-container">
                <label for="password">Contraseña</label>
                <input type="password" name="password" minlength="8" id="password-input-profile"/>
                <button class="webSymbols" type="button" onclick="showPassword()">L</button>
            </div>
        </section>
        
        <section class="seleccion-horario">
            <div class="data-container">
                <label for="horario">Horario</label>
                <select name="horario">
                    <option value="1">08:30 a 14:00 - 14:30 a 17:30</option>
                    <option value="3">09:00 a 14:00 - 14:30 a 17:30</option>
                </select>
            </div>
        </section>
        
        <section class="identity-data">
            <div class="data-container">
                <label for="dni">DNI</label>
                <input type="text" name="dni" value="<?=$_SESSION['identity']->dni?>" maxlength="9" pattern="[A-Za-z0-9]+" required/>
            </div>
            
            <div class="data-container">
                <label for="naf">Número de afilicación SS</label>
                <input type="text" name="naf" value="<?=$_SESSION['identity']->naf?>" maxlength="12" pattern="[A-Za-z0-9]+" required/>
            </div>
            
            <div class="data-container">
                <label for="firma">Firma</label>
                <input type="file" name="firma" accept="image/*"/>
            </div>            
        </section>
        
        <input type="submit" value="actualizar"/>
        
        <?php if(isset($_SESSION['update_ok'])): ?>
            <p class="update-ok"><?=$_SESSION['update_ok']?></p>
        <?php 
            endif;
            unset($_SESSION['update_ok']);
        ?>
            
        <?php if(isset($_SESSION['update_bad'])): ?>
            <p class="update-bad"><?=$_SESSION['update_bad']?></p>
        <?php 
            endif;
            unset($_SESSION['update_bad']);
        ?>
    </form>
</div>