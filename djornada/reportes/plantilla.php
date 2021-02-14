<style>    
    .plantilla-reporte-jornada{
        margin: 0;
        padding: 10%;
        padding-top: 2%;
        padding-bottom: 2%;
        color: black;
        font-family: 'Arial';
    }
    
    .plantilla-reporte-jornada h1{
        font-size: 30px;
        text-align: center;
        margin-bottom: 15px;
    }
    
    .plantilla-reporte-jornada .titulo{
        font-weight: bold;
    }
    
    .plantilla-reporte-jornada .datos-empresa,
    .plantilla-reporte-jornada .datos-trabajador-reporte,
    .plantilla-reporte-jornada .periodo-jornada,
    .plantilla-reporte-jornada p{
        margin-left: 5%;
    }
    
    .plantilla-reporte-jornada .datos-empresa{
        margin-bottom: 25px;
    }
    
    .plantilla-reporte-jornada .datos-empresa .identificacion-empresa .last_title{
        margin-left: 5%;
    }
    
    .plantilla-reporte-jornada .datos-trabajador-reporte{
        margin-bottom: 20px;
    }
    
    .plantilla-reporte-jornada .datos-trabajador-reporte .identificacion-trabajador .last_title{
        margin-left: 5%;
    }
    
    .plantilla-reporte-jornada .periodo-jornada{
        margin-bottom: 5px;
    }
    
    .plantilla-reporte-jornada .tabla-reporte{
        margin-bottom: 75px;
    }
    
    .plantilla-reporte-jornada table{
        margin: auto;
        margin-top: 25px;
        border-collapse: collapse;
    }
    
    .plantilla-reporte-jornada table tr td,
    .plantilla-reporte-jornada table tr th{
        text-align: center;
        font-size: 13px;
        padding: 3px;
        width: 100;
    }
    
    .plantilla-reporte-jornada table tr td{
        padding-top: 5;
    }
    
    .plantilla-reporte-jornada p{
        color: black;
        padding-right: 5%;
    }
</style>

<div class="plantilla-reporte-jornada">
    <h1>Registro diario de jornada</h1>
    <div class="datos-empresa">
        <div class="nombre-empresa">
            <span class="titulo">Empresa: </span> <?=$empresa?>
        </div>
        <div class="identificacion-empresa">
            <span class="titulo">CIF/DNI: </span> <?=$cif?>
            <span class="titulo last_title">Código cuenta cotización: </span> <?=$cuenta_cotizacion?>
        </div>
    </div>

    <div class="datos-trabajador-reporte">
        <div class="nombre-trabajador">
            <span class="titulo">Trabajador: </span> <?=$nombre.' '.$apellidos?>
        </div>
        <div class="identificacion-trabajador">
            <span class="titulo">NIF/NIE: </span> <?=$dni?>
            <span class="titulo last_title">NAF: </span> <?=$naf?>
        </div>
    </div>

    <div class="periodo-jornada">
        <span class="titulo">Periodo: </span> <?=Utils::nameOfTheMonth(date('m', time()))?> <strong>de: </strong> <?=date('Y', time());?>
    </div>

    <div class="tabla-reporte">
        <table border='1'>
            <tr>
                <th rowspan="2">
                    Dia
                </th>

                <th colspan="2">
                    Horario de mañana
                </th>

                <th colspan="2">
                    Horario de tarde
                </th>
                
                <th rowspan="2">
                    Firma
                </th>
            </tr>

            <tr>
                <th>
                    Hora entrada
                </th>

                <th>
                    Hora salida
                </th>

                <th>
                    Hora entrada
                </th>

                <th>
                    Hora salida
                </th>
            </tr>

        <?php for($i = 1; $i <= 31; $i++): ?>
            <!--Script de validación de jornada-->
            <?php
                $jornada->setDia_mes($i);
                $asistencia = $jornada->getAllByUserAndDay();
                $asistencia = ($asistencia != false) ? $asistencia->fetch_object() : false;
            ?>
            <tr>
                <td style="padding-top: 25">
                    <?=$i?>
                </td>

                <td style="padding-top: 25">
                    <?=$hora = ($asistencia != false) ? $asistencia->e_matu : ''?>
                </td>

                <td style="padding-top: 25">
                    <?=$hora = ($asistencia != false) ? $asistencia->s_matu : ''?>
                </td>
                
                <td style="padding-top: 25">
                    <?=$hora = ($asistencia != false) ? $asistencia->e_tarde : ''?>
                </td>

                <td style="padding-top: 25">
                    <?=$hora = ($asistencia != false) ? $asistencia->s_tarde : ''?>
                </td>

                <td style="padding-top: 20">
                    <?php if(($asistencia != false) && ($asistencia->s_matu != '') && ($asistencia->s_tarde != '')): ?>
                        <img src="uploads/firmas/<?=$_SESSION['identity']->username?>/<?=$_SESSION['identity']->firma?>" class="img-firma"/>
                    <?php endif; ?>    
                </td>
            </tr>
        <?php endfor; ?>
        </table>
    </div>
    <p>
        <strong>
            Registro diario de la jornada de los trabajadores en cumplimiento de la 
            obligación establecida en los artículos 12.4.c, 35.5 y 34.9 del Estatuto de los Trabajadores.
        </strong>
    </p>

    <p>
        En Barcelona a <?=date('d', time()) . ' de ' . Utils::nameOfTheMonth(date('m', time())) . ' de ' . date('Y', time())?>
    </p>
</div>