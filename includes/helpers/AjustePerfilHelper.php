<?php

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
    <body>
        <div class="info_session"> 
            <div class="contenedor_texto"> 
                <p>Eliminar Cuenta</p> 
            </div> 
            <div class="contenedor_imagen"> 
                <button type="submit" name="delete_button" id="DeleteUserButton"> 
                    <img src="$RemoveImage" height="30" width="30" alt="Foto de eliminacion de cuenta">
                </button> 
            </div> 
        </div> 
    </header>
    EOS;

    echo "<script> var linkEliminar = '" . $rutaDel . "'; </script>";
    return $html;
}

function displayFormularioModificar(){

    /* Crea el formulario de moficacion */ 
    $form = new FormularioModificacionPerfil(); 
    $html = $form->gestiona();
    $html =<<<EOS
    <section class= 'formulario_style'>
    $html
    </section> 
    EOS;

    return $html;
}