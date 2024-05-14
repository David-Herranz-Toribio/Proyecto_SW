<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$user = null;
$content = "<section class='default'>";

if(isset($_SESSION['username'])){
    $user = filter_var($_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content .= showCarrito($user);
}
else {
    header('Location:'. VIEWS_PATH . '/log/Login.php');
    exit(); 
}
$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;
