<?php
require_once '../../Config.php';
require_once HELPERS_URL . '/MusicaHelper.php';
require_once HELPERS_URL . '/PostHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarCancion();

$yo = isset($_SESSION['username']) ? filter_var($_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
$id_cancion = isset($_GET["id_cancion"]) ? filter_var($_GET["id_cancion"], FILTER_VALIDATE_INT) : null;

$cancion = SW\classes\Cancion::obtenerCancionPorID($id_cancion);

$content = "<div id='songStyle'>";
$content .= "<h1> ".htmlspecialchars($cancion->getCancionTitulo())."</h1>"; 

$content .= displayMusicStyle($cancion);

$content.= "<div >"; 

$content .= crearFormReseña($id_cancion ,'cancion', $yo);
$content.= "</div >"; 
$content .= "</div>"; 

$scripts = ['playerLogic.js','confirmacion.js']; 
require_once LAYOUT_URL;
