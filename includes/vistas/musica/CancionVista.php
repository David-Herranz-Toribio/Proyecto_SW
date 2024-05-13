<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/MusicaHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarCancion();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$id_cancion = $_GET["id_cancion"] ?? NULL;

$cancion= SW\classes\Cancion:: obtenerCancionPorID($id_cancion); 

$content = "<div class= 'songlist'> "; 
$content .= displayMusicStyle($cancion);
$content .= "</div>"; 
require_once LAYOUT_URL;