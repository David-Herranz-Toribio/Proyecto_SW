<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/ExplorarCancionesHelper.php';


$content = '';

// Mostrar canciones del género seleccionado
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

require_once LAYOUT_URL;