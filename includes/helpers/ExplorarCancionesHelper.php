<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Cancion.php';


function displaySongsFromArtist($id_user){

    $songs = SW\classes\Cancion::obtenerCancionesDeArtista($id_user);
    if(!$songs)
        return displayErrorMessage("El artista @" . $id_user . " no tiene canciones");


    // Mostrar canciones del artista
    $html = "<div class='songlist'>";
    foreach($songs as $song){
        $html .= display_a_song($song);
    }
    $html .= "</div>";

    return $html;
}

function display_a_song($song){

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
    <div class="songsNotFound">
        <h2> $message </h2>
    </div>
    EOS;

    return $html;
}