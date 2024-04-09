<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Usuario.php'; 


$perfil= Usuario::buscaUsuario($_SESSION['username']); 

$act_nickname = $perfil->getNickname(); 
$act_username = $perfil->getUsername(); 
$act_descr = $perfil->getDescrip(); 
$act_email = $perfil->getEmail();
$act_password = $perfil->getPassword(); 
$act_nacimiento = $perfil->getBirthdate(); 
$rutaMod = HELPERS_PATH . '/ModificarPerfilHelper.php'; 
$rutaDel = HELPERS_PATH . '/ProcesarEliminarUsuario.php'; 
$link = VIEWS_PATH . '/log/Logout.php';
$RemoveImage = IMG_PATH . '/remove_user_.png';
$altText = 'Foto de eliminacion de cuenta';
$texto = "Eliminar Cuenta "; 
//Primero comprobar si es artista 

$form_modificar= <<<EOS
    <section class= "formulario_style">
    <fieldset class= "formRegistro">
    <legend> Modifica tu cuenta </legend> 
        <form action= $rutaMod method="post">
            <input hidden name="id_user" value= "$act_username">
             
            <input hidden name="isArtist" value="0"> 
            <label> Nickname </label>
            <p></p> 
            <input type="text" name= "modify_nickname" value= "$act_nickname">

            <p></p> 
                
            <label> Descripcion </label> 
            <p></p> 
            <input type="text" name= "modify_descrip" value= "$act_descr">

            <p> </p> 

            <label> Email </label>
            <p></p> 
            <input type="text" name="modify_email" value= "$act_email">
      
            <p></p> 

            <label> Password </label>
            <p></p> 
            <input type="password" name="modify_password">
                
            <p></p> 
                
            <label> Birthdate </label>
            <p></p> 
            <input type="date" name="modify_birthdate" value= $act_nacimiento>
            <p></p> 

            <button type="submit" name="register_button" > Modificar </button>
        </form>
    </fieldset>
    </section> 
EOS; 

$cambio_modo= <<<EOS
<section class= 'botonesEstilo'> 
<button type= "button" onclick= "toClaro()"> Modo claro </button> 
<button type= "button" onclick= "toOscuro()"> Modo oscuro </button> 
<p></p> 
<p></p> 
    <form action= $rutaDel method="post2">
        <div class= 'info_session'> 
                <div class= 'contenedor_texto'> 
                <p>
                    $texto
                <p> 
                </div> 
                <div class= 'contenedor_imagen'> 
                    <button type="submit" name="delete_button">
                    <img src="$RemoveImage" height="30" width="30" alt="$altText">
                    </button>
                </div> 
            </div> 
    </form>
</section> 
EOS; 

$content= <<<EOS
    $form_modificar
    $cambio_modo
EOS; 


require_once LAYOUT_URL; 






