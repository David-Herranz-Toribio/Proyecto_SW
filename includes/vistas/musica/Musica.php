<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/MusicaHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarPlaylists();

$username = isset($_SESSION['username']) ? filter_var($_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : NULL;
$content = '';
if(isset($_SESSION['username']))
    $content = showPlaylists($username);
else{
    header('Location:'. VIEWS_PATH . '/log/Login.php');
    exit(); 
    $content .= displayViewToNotLogged();
}

$scripts = ['playerLogic.js', 'desplegable.js', 'confirmacion.js'];
require_once LAYOUT_URL;