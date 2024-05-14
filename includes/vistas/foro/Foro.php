<?php
require_once '../../Config.php';
require_once HELPERS_URL . '/PostHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarPosts();

$yo = isset($_SESSION['username']) ? filter_var($_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
$opcion = isset($_GET['opcion']) ? filter_var($_GET['opcion'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : NULL;
$content = showMainPosts($yo, $opcion);

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;
