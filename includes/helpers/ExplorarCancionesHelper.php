<?php

require_once '../../Config.php';


function displaySongsWithGenre($genre){

    // Mostrar una serie de canciones del genero musical 'genre'
}

function displayAllMusicTypes(){

    $viewPath = VIEWS_PATH . '/musica/ExplorarCanciones.php';
    $generosMusicales = ['Pop', 'Rock', 'Rap', 'Hip Hop', 'Latino', 'Jazz', 'R&B', 'K-Pop',
                        'J-Pop', 'Dubstep', 'Clásica', 'Disco', 'Funk', 'Jazz', 'Reggae', 'Metal'];

    $html =<<<EOS
    <h1 class='texto_infor'> Descubrir nueva música </h1>
    <div class='tablaGeneros'>
    EOS;

    foreach($generosMusicales as $genero){
        $html.=<<<EOS
        <div class='musicalGenre'>
            <a href=$viewPath?genre=$genero>
                $genero
            </a>
        </div>
        EOS;
    }

    $html.=<<<EOS
    </div>
    EOS;

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