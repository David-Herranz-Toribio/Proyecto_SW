<?php
require_once '../../Config.php';
require_once HELPERS_URL . '/PostHelper.php';


// Selección de barra d búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$opcion = $_GET['opcion'] ?? NULL;
$content = showMainPosts($yo, $opcion);

require_once LAYOUT_URL;