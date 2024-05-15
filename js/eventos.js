$(document).ready(function() {

    //Validaciones al crear una playlist 
    $("#campoNombrePlaylist").change(function(){
        var url= "../../helpers/compruebaPlaylist.php?user=" + $('#id_user').val() + "&nombrePlaylist=" + $('#campoNombrePlaylist').val(); 
        $.get(url,playlistExiste); 
    }); 

    //Validaciones al registrarse 
    $("#campoUser").change(function(){
       var url= "../../helpers/compruebaUsuario.php?user=" + $('#campoUser').val(); 
       $.get(url,usuarioExiste);
    }); 

    $("#campoEmail").change(function(){
        const campo = $("#campoEmail"); 
		campo[0].setCustomValidity(""); 

		const esCorreoValido = campo[0].checkValidity();
		if (esCorreoValido && correoValido(campo.val())) {
			$("#validEmail").html( '&#x2714');  
			campo[0].setCustomValidity("");
		} else {			
			$("#validEmail").html( '&#x26a0'); 
			campo[0].setCustomValidity(
				"El correo debe ser válido y acabar por @gmail.com");
		}
    })

    $("#campoPassword").keyup(function(event){

        var password = $('#campoPassword').val(); 
        if(password.length < 8){
            $("#validPassword").html('&#x26a0 Mín 8 caracteres'); 
        }
        else $("#validPassword").html('&#x2714'); 
    })


    function usuarioExiste(data, status){

        switch(data){
            case 'existe': 
             $("#validUser").html( 'Ya existe &#x26a0');
            break; 

            case 'disponible': 
            $("#validUser").html( 'Disponible &#x2714');
            break;  
        }
    }


    function correoValido(correo) {
		
	    return correo.endsWith('@gmail.com'); 
	}


    function playlistExiste(data, status){
        switch(data){
            case 'existe': 
             $("#validPlaylist").html( 'Ya existe &#x26a0');
            break; 

            case 'disponible': 
            $("#validPlaylist").html( 'Disponible &#x2714');
            break;  
        }
    }

})

function startTimer(diference) {
    let diff = diference;

    // Actualizar el contador cada segundo
    const interval = setInterval(function() {
        diff -= 1000;
        const distance = diff;

        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("time").innerHTML = days + "d " + hours + "h " +
            minutes + "m " + seconds + "s ";

        if (distance < 0) {
            clearInterval(interval);
            document.getElementById("time").innerHTML = "EXPIRED";
            var botonEliminarSus = document.getElementById("botonEliminarSus");
            botonEliminarSus.style.display = 'none';

            setTimeout(function() {
                botonEliminarSus.click();
            }, 1500);            
        }
    }, 1000);
}

function peticionAjaxSus(url, data) {
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response) {

            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX: ", textStatus, errorThrown);
        }
    });
}