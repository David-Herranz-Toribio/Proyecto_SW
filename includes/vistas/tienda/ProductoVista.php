<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';


// Barra de búsqueda para usuarios seguidos y seguidores
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$prod = $_GET["prod"] ?? NULL;

$content = showProduct($yo, $prod);
require_once LAYOUT_URL;