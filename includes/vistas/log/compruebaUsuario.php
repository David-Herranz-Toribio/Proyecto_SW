<?php
require_once "../../Config.php"; 
require_once CLASSES_URL . "/Usuario.php"; 


// Selección de barra d búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$user = $_GET['user']; 
if(SW\classes\Usuario::buscaUsuario($user)==false){
    echo("disponible"); 
}

else echo("existe"); 