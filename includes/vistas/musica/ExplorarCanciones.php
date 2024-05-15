<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/ExplorarCancionesHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarCancion();

// Mostrar canciones del género seleccionado
$content = '';
if(isset($_GET['genre'])){
    $genero = htmlspecialchars($_GET['genre'], ENT_QUOTES);
    $content = displaySongsWithGenre($genero);
}

// Mostrar todos los generos musicales
else{
    if(!isset($_SESSION['username'])){
        $content = displayErrorMessage("Debes estar loguead@ para ver esta página");
    }
    else{
        $content = displayAllMusicTypes();
    }
}
$scripts = ['playerLogic.js', 'desplegable.js', 'confirmacion.js'];
require_once LAYOUT_URL;