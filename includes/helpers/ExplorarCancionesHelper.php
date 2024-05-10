<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/ListaGenerosMusicales.php';
require_once CLASSES_URL . '/Cancion.php'; 

function displaySongsWithGenre($genre){

    // Mostrar una serie de canciones del genero musical 'genre'
    $canciones= SW\classes\Cancion::obtenerCancionesporGenero($genre);
    
    if($canciones==NULL){
        $listaCanciones= displayErrorMessage("Sin resultados");  
    }

    else {
        $listaCanciones= '<div class= "songlist">'; 
        $listaCanciones .= <<<EOS
        <p> Canciones de <strong> $genre </strong> </p> 
        EOS; 
        foreach($canciones as $cancion_act){
            $listaCanciones .= display_a_song($cancion_act); 
        }

        $listaCanciones .= "</div>";
    } 
    return $listaCanciones; 
}

function displayAllMusicTypes(){

    $viewPath = VIEWS_PATH . '/musica/ExplorarCanciones.php';

    $html =<<<EOS
    <h1 class='texto_infor'> Descubrir nueva música </h1>
    <div class='tablaGeneros'>
    EOS;

    foreach(ListaGenerosMusicales::getListaGenerosMusicales() as $genero){
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