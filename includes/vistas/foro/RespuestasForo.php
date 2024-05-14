<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/PostHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$id_post = isset($_POST["id_padre"]) ? filter_var($_POST["id_padre"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : NULL;
$yo = isset($_SESSION['username']) ? filter_var($_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
$content = showResp($id_post, $yo);

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;
