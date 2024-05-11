<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/PlaylistViewHelper.php';
require_once CLASSES_URL . '/Playlist.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

// Obtener el id de la playlist seleccionada por el usuario
$playlist_id = isset($_GET['id']) ? $_GET['id'] : NULL;

// Obtener playlist de la base de datos
$playlist = SW\classes\Playlist::obtenerPlaylistByID($playlist_id);

$content = '';
if(!$playlist){
    $content = displayErrorMessage("Error: Playlist no encontrada");
}
else{
    // Mostrar el contenido de la playlist
    $content = displayPlaylist($playlist);
}

require_once LAYOUT_URL;