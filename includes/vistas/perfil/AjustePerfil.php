<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Usuario.php'; 
require_once CLASSES_URL . '/FormularioModificacion.php'; 

$rutaEstiloClaro=  CSS_PATH .'/estiloClaro.css'; 
$rutaEstiloOscuro= CSS_PATH .'/estiloOscuro.css'; 

$perfil = es\ucm\fdi\aw\Usuario::buscaUsuario($_SESSION['username']); 
$image = $perfil->getPhoto();  
$rutaDel = HELPERS_PATH . '/ProcesarEliminarUsuario.php'; 
$RemoveImage = IMG_PATH . '/remove_user_.png';

/*Cambio modo claro/oscuro */ 
$cambio_modo= <<<EOS
<section class= 'botonesEstilo'> 
<button type= "button" onclick= "toggleStyle('$rutaEstiloClaro')"> Modo claro </button> 
<button type= "button" onclick= "toggleStyle('$rutaEstiloOscuro')"> Modo oscuro </button> 
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
<form action= $rutaDel method="post2">
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
$form= new FormularioModificacion(); 

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


/*
$act_nickname = $perfil->getNickname(); 
$act_username = $perfil->getUsername(); 
$act_descr = $perfil->getDescrip(); 
$act_email = $perfil->getEmail();
$act_password = $perfil->getPassword();  
$rutaMod = HELPERS_PATH . '/ModificarPerfilHelper.php'; 
$link = VIEWS_PATH . '/log/Logout.php';

$altText = 'Foto de eliminacion de cuenta';
$texto = "Eliminar Cuenta "; 
//Primero comprobar si es artista 

$form_modificar= <<<EOS
    <section class= "formulario_style">
    <fieldset class= "formRegistro">
    <legend> Modifica tu cuenta </legend> 
        <form action= $rutaMod method="post"enctype = "multipart/form-data">
            <input hidden name="id_user" value= "$act_username">
             
            <input hidden name="isArtist" value="0"> 
            <label> Nickname </label>
             
            <input type="text" name= "modify_nickname" value= "$act_nickname">

            <label> Descripcion </label> 
         
            <input type="text" name= "modify_descrip" value= "$act_descr">

            <label> Email </label>
            
            <input type="text" name="modify_email" value= "$act_email">
      

            <label> Password </label>
            
            <input type="password" name="modify_password">

            <label> Modificar foto de perfil </label>
                <input type = "file" name = "image" accept = "image/*">
                
            <button type="submit" name="register_button" > Modificar </button>
        </form>
    </fieldset>
    </section> 
EOS; 
*/