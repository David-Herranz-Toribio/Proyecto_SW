<?php

require_once '../../Config.php';

require_once RUTA_CLASSES.'/Usuario.php'; 


$perfil= Usuario::buscaUsuario($_SESSION['username']); 

$act_nickname= $perfil->getNickname(); 
$act_username= $perfil->getUsername(); 
$act_email= $perfil->getEmail();
$act_password= $perfil->getPassword(); 
$act_nacimiento= $perfil->getBirthdate(); 
$rutaMod= RUTA_HELPERS_PATH.'/ModificarPerfilHelper.php'; 
//Primero comprobar si es artista 

$form_modificar= <<<EOS
    <section class= "formulario_style">
    <fieldset class= "formRegistro">
    <legend> Modifica tu cuenta </legend> 
        <form action= $rutaMod method="post">
            <input hidden name="id_user" value= $act_username> 
            <input hidden name="isArtist" value="0"> 
            <label> Nickname </label>
            <p></p> 
            <input type="text" name= "modify_nickname" value= $act_nickname>

            <p></p> 
                
            <label> Email </label>
            <p></p> 
            <input type="text" name="modify_email" value= $act_email>
      
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


$content= <<<EOS
    $form_modificar

EOS; 


require_once RUTA_LAYOUTS; 






