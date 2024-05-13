<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/MusicaHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarPlaylists();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$content = '';
if(isset($_SESSION['username']))
    $content = showPlaylists($username);
else{
    header('Location:'. VIEWS_PATH . '/log/Login.php');
    exit(); 
    $content .= displayViewToNotLogged();
}

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;