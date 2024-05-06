<?php

require_once '../../Config.php';
require_once FORMS_URL . '/FormularioExplorarCanciones.php';


function displayAllMusicTypes(){

    $form = new FormularioExplorarCanciones();

    $html =<<<EOS
    <h1 class='texto_infor'> Explora la música que más te gusta </h1>
    <section class='explorarCanciones'>
    EOS;
    $html .= $form->gestiona();
    $html .= "</section>";

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