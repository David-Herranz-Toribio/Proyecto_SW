<?php
require_once "../Config.php"; 
require_once CLASSES_URL . "/Playlist.php"; 


// Selección de barra dee búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$nombrePlaylist = filter_var($_GET['nombrePlaylist'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
$user= filter_var($_GET['user'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

if(SW\classes\Playlist::existeNombrePlaylist($user, $nombrePlaylist)==false){ //Comprueba si ese user ya tiene una playlist creada con ese nombre 
    echo("disponible"); 
}

else echo("existe"); 