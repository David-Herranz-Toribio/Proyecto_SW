<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';
require_once CLASSES_URL . '/FormularioSuscripcion.php';    
require_once CLASSES_URL . '/Producto.php';
require_once CLASSES_URL . '/Suscripcion.php';


// Selección de barra d búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();
$topSearchBar->notDisplaySearchBar();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
if(!$yo){
    header('Location: ' . VIEWS_PATH . '/log/Login.php');
    exit();
}
$content = suscripcionHTML($yo);

require_once LAYOUT_URL;