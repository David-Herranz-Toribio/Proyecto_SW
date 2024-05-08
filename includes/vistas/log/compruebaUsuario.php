<?php
    require_once "../../Config.php"; 
    require_once CLASSES_URL . "/Usuario.php"; 

    $user= $_GET['user']; 

    if(SW\classes\Usuario::buscaUsuario($user)==false){
        echo("disponible"); 
    }

    else echo("existe"); 

?>