<?php
require_once '../../Config.php';
require_once HELPERS_URL . '/MusicaHelper.php';
require_once HELPERS_URL . '/PostHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarCancion();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$id_cancion = $_GET["id_cancion"] ?? NULL;

$cancion= SW\classes\Cancion:: obtenerCancionPorID($id_cancion); 

$content = "<div id='songStyle'>";
$content .= "<h1> ".$cancion->getCancionTitulo()."</h1>"; 

$content .= displayMusicStyle($cancion);

$content.= "<div >"; 

$content .= crearFormReseña($id_cancion ,'cancion', $yo);
$content.= "</div >"; 
$content .= "</div>"; 


require_once LAYOUT_URL;