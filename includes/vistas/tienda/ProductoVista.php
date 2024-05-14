<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarProductos();

$yo = isset($_SESSION['username']) ? filter_var($_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
$prod = isset($_GET["prod"]) ? filter_var($_GET["prod"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

$content = showProduct($yo, $prod);

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;