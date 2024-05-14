<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarProductos();

$yo = isset($_SESSION['username']) ? filter_var($_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
$content = "<section class='default'>";
if($yo){
    $content .= "<h1 class='texto_infor'> Productos </h1>";
    $content .= showProducts($yo);
}
else {
    header('Location:'. VIEWS_PATH . '/log/Login.php');
    exit(); 
}
$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;