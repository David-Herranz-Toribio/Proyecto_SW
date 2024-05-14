<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/PostHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$id_post = $_POST["id_padre"] ?? NULL;
$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$content = showResp($id_post, $yo);

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;