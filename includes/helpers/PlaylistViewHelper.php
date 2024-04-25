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

    $playlistImage = IMG_PATH . '/songImages/portada1.jpg';

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
        <p> Cancion 1 </p>
        <p> Cancion 2 </p>
        <p> Cancion 3 </p>
        <p> Cancion 4 </p>
        <p> Cancion 5 </p>
        <p> Cancion 6 </p>
        <p> Cancion 7 </p>
        <p> Cancion 8 </p>
        <p> Cancion 9 </p>
        <p> Cancion 10 </p>
        <p> Cancion 11 </p>
        <p> Cancion 12 </p>
        <p> Cancion 13 </p>
        <p> Cancion 14 </p>
        <p> Cancion 15 </p>
        <p> Cancion 16 </p>
        <p> Cancion 17 </p>
        <p> Cancion 18 </p>
        <p> Cancion 19 </p>
        <p> Cancion 20 </p>
    </div>
    EOS;

    return $html;
}