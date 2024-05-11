<?php

require_once '../../Config.php';

function displayPlaylist($playlist){

    // Mostrar el header de la página -> info de la playlist, imagen, botones, etc...
    $html = displayPlaylistHeader($playlist);

    // Mostrar lista de canciones
    $html .= displayPlaylistSongs($playlist);

    return $html;
}

function displayPlaylistHeader($playlist){

    $playlistImage = IMG_PATH . '/songImages/' .$playlist->getPlaylistImagen();
    $playlistName = $playlist->getPlaylistNombre();
    $playlistID = $playlist->getIdPlaylist();
    $duracion = $playlist->getPlaylistDuracion();
    $creador = $playlist->getIdUsuario(); 
    $rutaPerfilCreador = VIEWS_PATH . '/perfil/Perfil.php'; 
    $fecha = $playlist->getPlaylistCreationDate();
    $crearMusicaPath = VIEWS_PATH . '/musica/CrearCancion.php';

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
                
                <button class='edit_playlist_buttons'><a href=''> Modificar playlist </a></button>
                <button class='edit_playlist_buttons'><a href=''> Eliminar playlist </a></button>
                <button class='edit_playlist_buttons'><a href=$crearMusicaPath?playlist=$playlistID> Añadir canción </a></button>
            </div>
        </div>
    </div>
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