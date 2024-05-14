<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/CrearAlbumHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$username = '';
$content = '';
if(!isset($_GET['user']) || !isset($_SESSION['username']) || $_GET['user'] !== $_SESSION['username']){
    $content = displayMessage("No tienes permiso para realizar esta acción");
}
else{
    $username = htmlspecialchars($_GET['user'], ENT_QUOTES);
    $content = displayFormulario($username);
}

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;