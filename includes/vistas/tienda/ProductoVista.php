<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarProductos();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$prod = $_GET["prod"] ?? NULL;

$content = showProduct($yo, $prod);

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;