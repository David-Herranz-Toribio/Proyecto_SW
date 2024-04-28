<?php

require_once '../../Config.php';

function displayPlaylist($id){

    // Mostrar el header de la página -> info de la playlist, imagen, botones, etc...
    $html = displayPlaylistHeader($id);

    // Mostrar lista de canciones
    $html .= displayPlaylistSongs($id);

    return $html;
}

function displayPlaylistHeader($id){

    $playlistImage = IMG_PATH . '/songImages/playlist1.jpg';

    $html =<<<EOS
    <div class="playlist_header">
        <div class="playlist_image">
            <img src="$playlistImage" alt="Imagen de la playlist">
        </div>

        <div class="playlist_info">
            <h1> Nombre de la playlist </h1>
            
            <div class="playlist_extra_info">
                <div class="playlist_username"> @username </div>
                <p> Duración: 2h 45min </p>
                <p> Creada: DD/MM/YYYY </p>
                <button> Modificar </button>
                <button> Eliminar </button>
            </div>
        </div>
    </div>
    EOS;

    return $html;
}

function displayPlaylistSongs($id){

    $html =<<<EOS
    <div class="songlist">
    EOS;

    for($i = 0; $i < 20; $i++){
        $html .= displaySong($i);
    }

    $html .= "</div>";

    return $html;
}

function displaySong($indice){

    $songImagePath = IMG_PATH . "/songImages/playlist1.jpg";

    $html =<<<EOS
    <div class="playlistSong">
        <img src="$songImagePath">
        <div class="songInfo">
            <div class="songNameAndArtist">
                <p> Cancion $indice </p>
                <p> Artista </p>
            </div>

            <div class="songAlbum">
                <p> Album </p>
            </div>

            <div class="songDate">
                <p> dd/mm/yyyy </p>
            </div>

            <div class="songLenght">
                <p> mm:ss </p>
            </div>
        </div>
    </div>
    EOS;

    return $html;
}