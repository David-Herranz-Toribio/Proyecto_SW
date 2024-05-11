<?php

function displayTitulo(){

    $html =<<<EOS
    <div class='user_image'>
        Ajuste de perfil
    </div>
    EOS;

    return $html;
}

function displayBotonesTemas(){

    $rutaEstiloClaro =  CSS_PATH .'/estiloClaro.css'; 
    $rutaEstiloOscuro = CSS_PATH .'/estiloOscuro.css';

    /* Cambio modo claro/oscuro */ 
    $html = <<<EOS
    <section class= 'botonesEstilo'> 
    <button type= "button" onclick= "toggleStyle('$rutaEstiloClaro')"> Modo claro </button> 
    <button type= "button" onclick= "toggleStyle('$rutaEstiloOscuro')"> Modo oscuro </button> 
    </section> 
    EOS;

    return $html;
}

function displayImagenPerfil($imagen){

    /* Te muestra tu actual foto de perfil */
    $html =<<<EOS
    <div class='user_image'>
        <img src='$imagen' height='100px' width='100px'>
    </div>
    EOS;

    return $html;
}

function displayBotonesEliminarCuenta(){

    /* Boton para eliminar la cuenta */ 
    $rutaDel = HELPERS_PATH . '/ProcesarEliminarUsuario.php'; 
    $RemoveImage = IMG_PATH . '/remove_user_.png';
    $html = <<<EOS
    <form action=$rutaDel method="post" onsubmit="return confirmarEliminacion();">
    <div class= 'info_session'> 
            <div class= 'contenedor_texto'> 
            <p>
                Eliminar Cuenta
            <p> 
            </div> 
            <div class= 'contenedor_imagen'> 
                <button type="submit" name="delete_button">
                <img src="$RemoveImage" height="30" width="30" alt="Foto de eliminacion de cuenta">
                </button>
            </div> 
        </div> 
    </form>

    <script>
    function confirmarEliminacion() {
        var ok = window.confirm("¿Estás seguro de que quieres eliminar tu usuario?");
        return ok;
    }
    </script>
    EOS;

    return $html;
}

function displayFormularioModificar(){

    /* Crea el formulario de moficacion */ 
    $form = new FormularioModificacion(); 
    $html = $form->gestiona();
    $html =<<<EOS
    <section class= 'formulario_style'>
    $html
    </section> 
    EOS;

    return $html;
}