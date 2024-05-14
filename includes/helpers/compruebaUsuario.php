<?php
require_once "../Config.php"; 
require_once CLASSES_URL . "/Usuario.php"; 


// Selección de barra dee búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$user = filter_var($_GET['user'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if(SW\classes\Usuario::buscaUsuario($user)==false){
    echo("disponible"); 
}

else echo("existe"); 