<div id="main-dashboard">
    <nav class="panel-description">
        <label id="main-panel">DESCARGAR JORNADAS</label>
    </nav>
</div>
<div class="download-jornadas-wrap">
    <?php 
        $i = 1;
        while($i <= 12): 
    ?>
        <?php if(is_file('reportes/'.$_SESSION['identity']->username.'/'.date('Y', time()).'/0'.$i.'-'.date('Y', time()).'.pdf')): ?>
            
            <a href="<?=base_url.'reportes/'.$_SESSION['identity']->username.'/'.date('Y', time()).'/0'.$i.'-'.date('Y', time()).'.pdf'?>" target="_blank">
                <img src="<?=base_url?>assets/images/download-pdf.png" />
                Diario de jornada<br/>
                Nombre: <?=$_SESSION['identity']->nombre?>
                Periodo: <?=Utils::nameOfTheMonth(date('m', time()))?> de <?=date('Y', time());?> 
            </a>
            
        <?php 
            endif; 
            $i++;
        ?>
    <?php endwhile; ?>
</div>