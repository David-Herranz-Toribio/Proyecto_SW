<?php
require_once "../../Config.php"; 
require_once CLASSES_URL . "/Usuario.php"; 


// Barra de búsqueda para usuarios seguidos y seguidores
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$user = $_GET['user']; 
if(SW\classes\Usuario::buscaUsuario($user)==false){
    echo("disponible"); 
}

else echo("existe"); 