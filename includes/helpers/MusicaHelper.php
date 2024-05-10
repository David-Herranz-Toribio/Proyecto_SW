<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Playlist.php';
require_once CLASSES_URL . '/Cancion.php';
require_once CLASSES_URL . '/Usuario.php';


function showPlaylists($username){
    
    // Obtener las playlists del usuario
    $playlists = SW\classes\Playlist::obtenerPlaylistsBD($username);

    // Mostrar header de las playlists
    $html = displayHeader();

    // Mostrar botones
    $html .= displayButtons($username);

    // Mostrar playlists
    $html .= displayPlaylists($playlists);

    return $html;
}

function displayHeader(){

    $html =<<<EOS
    <div class="musicHeader">
        <h1> Tu música </h1>
    </div>
    EOS;

    return $html;
}

function displayButtons($username){

    // Boton para crear playlist
    $viewPath = VIEWS_PATH . '/musica/CrearPlaylist.php';
    $buttonText = 'Crear playlist';

    // Si el usuario es artista -> Crear album en lugar de playlist
    if(SW\classes\Usuario::esArtista($username)){
        $viewPath = VIEWS_PATH . '/musica/CrearAlbum.php';
        $buttonText = 'Crear album';
    }

    // Mostrar boton
    $html =<<<EOS
    <div class="musicButtons">
        <button><a href="$viewPath?user=$username"> $buttonText </a></button>
    </div>
    EOS;

    return $html;
}

function displayPlaylists($playlists){

    if(!$playlists){

        $html =<<<EOS
        <section class="emptyMusicList">
            <p> No tienes ninguna playlist ¡Crea una ahora! </p>
        </section>
        EOS;

        return $html;
    }

    $html = '<section class="musicList">';

    // Mostrar todas las playlists
    foreach($playlists as $p){
        $html .= display_a_playlist($p);
    }

    $html .= '</section>';

    return $html;
}

function display_a_playlist($playlist){

    $id = $playlist->getIdPlaylist();
    $image = IMG_PATH . '/songImages/' . $playlist->getPlaylistImagen();
    $nombre = $playlist->getPlaylistNombre();
    $duracionTotal = $playlist->getPlaylistDuracion();
    $view_path = VIEWS_PATH . '/musica/PlaylistView.php';

    $html =<<<EOS
    <article class="music_playlist">
        <div class="music_playlist_image">
            <img src="$image" alt="Portada de la playlist">
        </div>

        <div class="music_playlist_info">
            <a href="$view_path?id=$id"><h2> $nombre </h2></a>
            <p> Duración total: $duracionTotal </p>
        </div>
    </article>
    EOS;

    return $html;
}

function displayViewToNotLogged(){
    
    $html =<<<EOS
    <h1 class="texto_infor"> No estas loguead@ para ver tu música</h1>
    EOS;

    return $html;
}