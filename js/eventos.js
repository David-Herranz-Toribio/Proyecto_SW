$(document).ready(function() {

    //Validaciones al registrarse 
    $("#campoUser").change(function(){
       var url= "compruebaUsuario.php?user=" + $('#campoUser').val(); 
       $.get(url,usuarioExiste);
    }); 

    $("#campoEmail").change(function(){
        const campo = $("#campoEmail"); 
		campo[0].setCustomValidity(""); 

		const esCorreoValido = campo[0].checkValidity();
		if (esCorreoValido || correoValidoUCM(campo.val())) {
			$("#validEmail").html( '&#x2714');  
			campo[0].setCustomValidity("");
		} else {			
			$("#validEmail").html( '&#x26a0'); 
			campo[0].setCustomValidity(
				"El correo debe ser válido y acabar por @ucm.es");
		}
    })

    $("#campoPassword").keyup(function(event){
        var password= $('#campoPassword').val(); 
        if(password.length<8){
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


    function correoValidoUCM(correo) {
		// tu codigo aqui (devuelve true ó false)
	    return correo.endsWith('@ucm.es'); 
	}
}
)