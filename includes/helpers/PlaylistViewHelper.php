<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioPlaylist.php'; 
require_once HELPERS_URL . '/MusicaHelper.php'; 


function displayPlaylist($playlist){

    // Mostrar el header de la página -> info de la playlist, imagen, botones, etc...
    $html = displayPlaylistHeader($playlist);

    // Mostrar lista de canciones
    $html .= displayPlaylistSongs($playlist);

    return $html;
}

function displayPlaylistHeader($playlist){

    // Rutas e información de la playlist
    $rutaPerfilCreador = VIEWS_PATH . '/perfil/Perfil.php';
    $crearMusicaPath = VIEWS_PATH . '/musica/CrearCancion.php';
    $playlistImage = IMG_PATH . '/songImages/' . $playlist->getPlaylistImagen();
    $playlistName = $playlist->getPlaylistNombre();
    $playlistID = $playlist->getIdPlaylist();
    $creador = $playlist->getIdUsuario();
    $fecha = $playlist->getPlaylistCreationDate();
  

    // Botones
    $buttons = displayButtons($playlistID, $crearMusicaPath, $creador, $playlistName);
    
    // Generar HTML
    $html =<<<EOS
    <div class="playlist_header">
        <div class="playlist_image">
            <img src="$playlistImage" alt="Imagen de la playlist">
        </div>

        <div class="playlist_info">
            <h1> $playlistName </h1>

            <div class="playlist_extra_info">
                <div class="playlist_username">
                    <a href="$rutaPerfilCreador?user=$creador"> @$creador </a>
                </div>
                
                <p> Creada el $fecha </p>
                $buttons
            </div>
        </div>
    </div>
    EOS;

    return $html;
}

function displayButtons($playlistID, $crearMusicaPath, $creador, $playlistName){

    $playButton = IMG_PATH . '/play_button.png';
    $rutaBorrar = HELPERS_PATH . '/ProcesarEliminarPlaylist.php'; 
    $rutaModificar = VIEWS_PATH . '/musica/ModificarPlaylist.php';

    $addButton = '';
    if( isset($_SESSION['username']) && (isset($_SESSION['isArtist']) && $_SESSION['isArtist']) ){
        $addButton =<<<EOS
        <button class='add_song_button'><a href=$crearMusicaPath?playlist=$playlistID> Añadir canción </a></button>
        EOS;
    }

    //  Evitar eliminar la playlist de favoritos
    if($playlistName != SW\classes\Playlist::$DEFAULT_PLAYLIST){ 

        $modificar_eliminar =<<<EOS
        <form action=$rutaModificar method="post">
            <input type= "hidden" name= "idPlaylist" value= '$playlistID'>
            <input type= "hidden" name= "idCreador" value= '$creador'>
            <button type= "submit"> Modificar playlist</button>
        </form>

        <form action=$rutaBorrar method="post"> 
            <input type= "hidden" name= "idPlaylist" value= '$playlistID'>
            <button type= "submit"> Eliminar playlist</button> 
        </form> 
        EOS;
    }

    else
        $modificar_eliminar = '';

    $html =<<<EOS
    <button class='playButton' id='startPlaylist'><img src=$playButton></button>
    <span hidden> {$playlistID} </span> 
    $modificar_eliminar
 
    $addButton
    EOS;

    return $html;
}

function displayPlaylistSongs($playlist){

    $all = SW\classes\Cancion::getSongsFromPlaylistID($playlist->getIdPlaylist());

    // Si no hay canciones, mostramos un mensaje
    if(!$all)
        return displayErrorMessage("No hay canciones en esta playlist");

    
    $html = '<div class="songlist">';
    foreach($all as $song){
        $html .= displayMusicStyle($song);
    }
    $html .= "</div>";

    return $html;
}

function displayErrorMessage($message){

    $html =<<<EOS
    <div class="playlistNotFound">
        <h2> $message </h2>
    </div>
    EOS;

    return $html;
}