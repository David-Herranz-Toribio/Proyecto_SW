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

    $playlistImage = $playlist->getPlaylistImagen();
    $playlistName = $playlist->getPlaylistNombre();
    $duracion = $playlist->getPlaylistDuracion();
    $fecha = $playlist->getPlaylistCreationDate();

    $html =<<<EOS
    <div class="playlist_header">
        <div class="playlist_image">
            <img src="$playlistImage" alt="Imagen de la playlist">
        </div>

        <div class="playlist_info">
            <h1> $playlistName </h1>
            
            <div class="playlist_extra_info">
                <div class="playlist_username"> @username </div>
                <p> Duración: $duracion </p>
                <p> Creada: $fecha </p>
                <button> Modificar </button>
                <button> Eliminar </button>
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
    $artista = $song->getIdArtista();
    $fecha = $song->getCancionFecha();
    $duracion = $song->getCancionDuracion();

    $html =<<<EOS
    <div class="playlistSong">
        <img src="$songImagePath">
        <div class="songInfo">
            <div class="songNameAndArtist">
                <p> $nombre </p>
                <p> $artista </p>
            </div>

            <div class="songAlbum">
                <p> Album </p>
            </div>

            <div class="songDate">
                <p> $fecha </p>
            </div>

            <div class="songLenght">
                <p> $duracion </p>
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