<div class="loadingReporte">
    <p class="webSymbols">
        V
    </p>
    <p class="loadingText">
        Generando su reporte mensual, espere por favor...
    </p>
</div>
<div id="main-dashboard">
    <nav class="panel-description">
        <label id="main-panel">DASHBOARD</label>
    </nav>

    <section>
        <form method="POST" action="<?=base_url?>jornada/index">
            <!-- Si no existe 'working', esto es, usuario en descanso, entonces se propone marcar la entrada -->
            <?php if(!isset($_SESSION['working'])): ?>
            
                <div id="fichar-entrada">
                    <span class="webSymbols">X</span>
                    <input type="submit" value="Marca la entrada" <?=isset($_SESSION['marcaje_complete']) ? 'disabled' : ''?>/>
                    <input type="hidden" value="entrar" name="tipo_fichaje"/>                    
                </div>
            
            <!-- Si existe 'working' el usuario puede marcar la salida -->
            <!-- Si se cumple la condición del último día de mes y último marcaje diario, se habilitará el evento onclick y producirá el efecto de carga en la web -->
            <?php else: ?>

                <div id="fichar-salida">
                    <span class="webSymbols">i</span>
                    <input type="submit" value="Marca la salida" role="button" <?= ((isset($_SESSION['ultimo_turno'])) && Utils::ultimoDiaDelMes()) ? "onclick='loadingEffect();'" : ''?>/>
                    <input type="hidden" value="salir" name="tipo_fichaje"/>
                </div>
            
            <?php endif; ?>

            <div id="status-work">
                <?php if(!isset($_SESSION['working'])): ?>
                
                    <span class="webSymbols">~</span>
                    <span id="status-resting">out of work</span>
                    <p id="status-description">
                        Ud. esta en descanso
                    </p>
                    
                <?php else: ?>
                    
                    <span class="webSymbols" id="work-symbol">~</span>
                    <span id="status-working">in working</span>
                    <p id="status-description">
                        Ud. esta trabajando
                    </p>
                    
                <?php endif; ?>

                <div id="system-time">
                    Hora(00 : 00 : 00)
                </div>
            </div>

            <div class="clearfix"></div>

            <input id="first-type-signing" type="radio" name="tipo_horario" value="real_time" checked/>
            <label for="tipo_horario">Tiempo real</label>

            <input type="radio" name="tipo_horario" value="horario_definido" class="marcar_por_horario"/>
            <label for="tipo_horario">Horario base</label>
            
            <div class="clearfix"></div>
            
            <!-- Si se selecciona el input radio horario base saldrá el select con los distintos perfiles horarios y enviará el id del seleccionado por POST -->
            <?php if(isset($_SESSION['activar_horario_base']) && $_SESSION['activar_horario_base'] == true): ?>
                <div class="select-horario-base">
                    <select name="hora_base" required>
                        <?php
                            $i = 1;
                            while($horarios = $horario->getAllHorarios($i)->fetch_object()):

                        ?>
                            <option value="<?=$i;?>">
                                <?=Utils::horarioOption($i)?>
                            </option>
                        <?php 
                            $i++;
                            endwhile; 
                        ?>
                    </select>
                </div>
            
                <div class="warningMessages">
                    
                </div>
            <?php endif; ?>
        </form>
        
        <div class="clearfix"></div>
        
        <!-- Mensajes y borrado de sesiones -->    
        <?php if(isset($_SESSION['firma_bad'])): ?>
            <p class="update-bad"><?=$_SESSION['firma_bad']?></p>
        <?php
            unset($_SESSION['firma_bad']);
            endif;
        ?>
            
        <?php
        if(isset($_SESSION['activar_horario_base'])){
            unset($_SESSION['activar_horario_base']);
        }
        ?>
            
        <?php
        if(isset($_SESSION['ultimo_turno'])){
            unset($_SESSION['ultimo_turno']);
        }
        ?>
            
        <?php if(isset($_SESSION['marcaje_ok'])): ?>
            <p class="update-ok"><?=$_SESSION['marcaje_ok']?></p>
        <?php
            unset($_SESSION['marcaje_ok']);
            endif;
        ?>
            
        <?php if(isset($_SESSION['marcaje_bad'])): ?>
            <p class="update-bad"><?=$_SESSION['marcaje_bad']?></p>
        <?php
            unset($_SESSION['marcaje_bad']);
            endif;
        ?>
            
        <?php if(isset($_SESSION['marcaje_complete'])): ?>
            <p class="update-ok"><?=$_SESSION['marcaje_complete']?></p>
        <?php endif; ?>
    </section>
</div>