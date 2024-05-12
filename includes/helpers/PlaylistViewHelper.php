<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioPlaylist.php'; 

function displayPlaylist($playlist){

    // Mostrar el header de la página -> info de la playlist, imagen, botones, etc...
    $html = displayPlaylistHeader($playlist);

    // Mostrar lista de canciones
    $html .= displayPlaylistSongs($playlist);

    return $html;
}

function displayPlaylistHeader($playlist){

    // Información de la playlist
    $playlistImage = IMG_PATH . '/songImages/' . $playlist->getPlaylistImagen();
    $playlistName = $playlist->getPlaylistNombre();
    $playlistID = $playlist->getIdPlaylist();
    $duracion = $playlist->getPlaylistDuracion();
    $creador = $playlist->getIdUsuario();
    $fecha = $playlist->getPlaylistCreationDate();
  
    // Rutas
    $rutaPerfilCreador = VIEWS_PATH . '/perfil/Perfil.php';
    $crearMusicaPath = VIEWS_PATH . '/musica/CrearCancion.php';
    

    $buttons = displayButtons($playlistID, $crearMusicaPath, $creador);

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
                
                <p> Duración: $duracion </p>
                <p> Creada el $fecha </p>
                $buttons
            </div>
        </div>
    </div>
    EOS;

    return $html;
}

function displayButtons($playlistID, $crearMusicaPath, $creador){
    $playButton = IMG_PATH . '/play_button.png';
    $rutaBorrar= HELPERS_PATH . '/ProcesarEliminarPlaylist.php'; 
    $rutaModificar= VIEWS_PATH . '/musica/ModificarPlaylist.php';

    $addButton = '';
    if( isset($_SESSION['username']) && (isset($_SESSION['isArtist']) && $_SESSION['isArtist']) ){
        $addButton =<<<EOS
        <button class='add_song_button'><a href=$crearMusicaPath?playlist=$playlistID> Añadir canción </a></button>
        EOS;
    }

    $html =<<<EOS
    <form action= $rutaModificar method= "post"> 
    <input type= "hidden" name= "idPlaylist" value= '$playlistID'>
    <input type= "hidden" name= "idCreador" value= '$creador'>  
    <button type= "submit"> Modificar playlist</button> 
    </form> 

    <form action= $rutaBorrar method= "post"> 
    <input type= "hidden" name= "idPlaylist" value= '$playlistID'>
    <button type= "submit"> Eliminar playlist</button> 
    </form> 


    <button class='playButton' id='startPlaylist'> <img src=$playButton></button>
    <span hidden> {$playlistID} </span> 
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
        $html .= displaySong($song);
    }
    $html .= "</div>";

    return $html;
}

function displaySong($song){

    $songImagePath = $song->getCancionImagen();
    $nombre = $song->getCancionTitulo();
    $id= $song->getIdCancion(); 
    $artista = $song->getIdArtista();
    $fecha = $song->getCancionFecha();
    $duracion = $song->getCancionDuracion();
    $rutaBorrar= HELPERS_PATH . '/ProcesarEliminarCancion.php';


    $html =<<<EOS
    <div class="playlistSong">
        <img src="$songImagePath">
        <div class="songInfo">
            <div class="songNameAndArtist">
                <p> $nombre </p>
                <p> $artista </p>
            </div>

            <div class="songDate">
                <p> $fecha </p>
            </div>

            <div class="songLenght">
                <p> $duracion </p>
            </div>

            <div> 
            <form action= $rutaBorrar method= "post"> 
                <input type= "hidden" name= "idCancion" value= '$id'>
                <button type= "submit"> &#10060 </button> 
            </form> 
            </div> 
        </div>
    </div>
    EOS;

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