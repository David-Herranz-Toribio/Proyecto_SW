<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';
require_once CLASSES_URL . '/FormularioSuscripcion.php';    
require_once CLASSES_URL . '/Producto.php';
require_once CLASSES_URL . '/Suscripcion.php';


// Barra de búsqueda para usuarios seguidos y seguidores
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
if(!$yo){
    header('Location: ' . VIEWS_PATH . '/log/Login.php');
    exit();
}
$content = suscripcionHTML($yo);

require_once LAYOUT_URL;