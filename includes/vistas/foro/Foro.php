<?php
require_once '../../Config.php';
require_once HELPERS_URL . '/PostHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$opcion = $_GET['opcion'] ?? NULL;
$content = showMainPosts($yo, $opcion);

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;