<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Usuario.php'; 
require_once CLASSES_URL . '/FormularioModificacion.php'; 


// Selección de barra d búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();
$topSearchBar->notDisplaySearchBar();

$rutaEstiloClaro =  CSS_PATH .'/estiloClaro.css'; 
$rutaEstiloOscuro = CSS_PATH .'/estiloOscuro.css'; 

$perfil = SW\classes\Usuario::buscaUsuario($_SESSION['username']); 
$image = $perfil->getPhoto();  
$rutaDel = HELPERS_PATH . '/ProcesarEliminarUsuario.php'; 
$RemoveImage = IMG_PATH . '/remove_user_.png';

/* Cambio modo claro/oscuro */ 
$cambio_modo= <<<EOS
<section class= 'botonesEstilo'> 
<button type="button" onclick="toggleStyle('$rutaEstiloClaro')"> Modo claro </button> 
<button type="button" onclick="toggleStyle('$rutaEstiloOscuro')"> Modo oscuro </button> 
</section> 
EOS; 

$profile_image_path = IMG_PATH . '/profileImages/' . $image;

$titulo =<<<EOS
<div class='user_image'>
    Ajuste de perfil
</div>
EOS;

/*Te muestra tu actual foto de perfil*/
$FotoPerfil =<<<EOS
<div class='user_image'>
    <img src='$profile_image_path' height='100px' width='100px'>
</div>
EOS;

/*Boton para eliminar la cuenta*/ 

$funcion_eliminar = <<<EOS
<form action= $rutaDel method="post2" >
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

EOS; 

/*Crea el formulario de moficicacion*/ 
$form = new FormularioModificacion(); 

$htmlform= $form->gestiona(); 

$content= <<<EOS
    $FotoPerfil
    $funcion_eliminar
    <section class= 'formulario_style'> 
    $htmlform
    </section> 
    $cambio_modo
EOS; 


require_once LAYOUT_URL; 


