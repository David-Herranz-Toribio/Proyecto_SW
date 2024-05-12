<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/CrearPlaylistHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

/*
    Verificar que:
        1- Tenemos el user del cliente
        2- El cliente está logueado
        3- El cliente es el mismo que el que está en la url
*/
$username = '';
if(!isset($_GET['user']) || !isset($_SESSION['username']) || $_GET['user'] !== $_SESSION['username']){
    $content = displayMessage("No tienes permiso para realizar esta acción");
}
else{
    $username = htmlspecialchars($_GET['user'], ENT_QUOTES);
    $content = displayFormulario($username);
}


$scripts= ['eventos.js']; 
require_once LAYOUT_URL;