function actual(){
    momentoActual = new Date();
    hora = momentoActual.getHours();
    minuto = momentoActual.getMinutes();
    segundo = momentoActual.getSeconds();
    
    if (hora < 10) {
        hora = "0" + hora;
    }
    
    if (minuto < 10) { 
        minuto = "0" + minuto;
    }
    
    if (segundo < 10) { 
        segundo = "0" + segundo;
    }

    mireloj = hora + " : " + minuto + " : " + segundo;	
    
    return mireloj; 
}

function actualizar() {
    mihora = actual();
    mireloj = document.getElementById("system-time");
    mireloj.innerHTML = 'Hora(' + mihora + ')';
}

setInterval(actualizar, 1000); //iniciar temporizador


