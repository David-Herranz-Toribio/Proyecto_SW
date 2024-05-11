<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';
require_once CLASSES_URL . '/FormularioSuscripcion.php';    
require_once CLASSES_URL . '/Producto.php';
require_once CLASSES_URL . '/Suscripcion.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
if(!$yo){
    header('Location: ' . VIEWS_PATH . '/log/Login.php');
    exit();
}
$scripts = ['eventos.js'];
$content = suscripcionHTML($yo);

require_once LAYOUT_URL;