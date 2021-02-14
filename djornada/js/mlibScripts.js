function showPassword() {
    var tipo = document.getElementById("password-input-profile");
    if (tipo.type == "password") {
        tipo.type = "text";
    } else {
        tipo.type = "password";
    }
}

window.addEventListener('load', function () {
    
    var input_tipo_horario = document.querySelector('.marcar_por_horario') != null ? document.querySelector('.marcar_por_horario') : null;
    var input_tipo_real = document.querySelector('#first-type-signing') != null ? document.querySelector('#first-type-signing') : null;
    
    if(input_tipo_horario != null || input_tipo_real != null){
        input_tipo_horario.addEventListener('click', function(){
           document.querySelector('.select-horario-base').style.display = 'block';
           document.querySelector('.select-horario-base').style.animation = 'showSlow 400ms linear';
           var warningMessages = document.querySelector('.warningMessages');
           warningMessages.style.display = 'block';
           warningMessages.innerHTML = `
                                        Advertencia: La selección del <strong>horario base</strong> es diaria, el horario base que elijas se mantendrá por todo el día, mañana podrás seleccionar otro.
                                       `;
        });
       
       input_tipo_real.addEventListener('click', function(){
           document.querySelector('.select-horario-base').style.display = 'none';
           document.querySelector('.warningMessages').style.display = 'none';
        });
    }
    
});