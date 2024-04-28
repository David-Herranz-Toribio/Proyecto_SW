<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Playlist.php';
require_once CLASSES_URL . '/Cancion.php';


function showPlaylists($username){
    
    // Obtener las playlists del usuario
    $playlists = SW\classes\Playlist::obtenerPlaylistsBD($username);

    // Mostrar header de las playlists
    $html = displayHeader();

    // Mostrar botones
    $html .= displayButtons();

    // Mostrar playlists
    $html .= displayPlaylists($playlists);

    // Mostrar artistas que sigues
    $html .= displayFollowingArtists($username);

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

function displayButtons(){

    $crearPlaylistView = VIEWS_PATH . '/musica/CrearPlaylist.php';

    // Boton para crear playlists
    $html =<<<EOS
    <div class="musicButtons">
        <form action=$crearPlaylistView method="get">
            <button> Crear playlist </button>
        </form>
    </div>
    EOS;

    return $html;
}

function displayPlaylists($playlists){

    if(!$playlists){

        $html =<<<EOS
        <section class="emptyMusicList">
        <p> La playlist está vacía </p>
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
    $image = $playlist->getPlaylistImagen();
    $nombre = $playlist->getPlaylistNombre();
    $duracionTotal = $playlist->getPlaylistDuracion();

    $html =<<<EOS
    <article class="music_playlist">
        <div class="music_playlist_image">
            <img src="$image" alt="Portada de la playlist">
        </div>

        <div class="music_playlist_info">
            <a href="PlaylistView.php?id=$id"><h2> $nombre </h2></a>
            <p> Duración total: $duracionTotal </p>
        </div>
    </article>
    EOS;

    return $html;
}

function displayFollowingArtists($username){

    // Mostrar los artistas a los que el usuario sigue
    // Imagen del artista, nombre y link a su perfil
}

function displayFooter(){

    $html =<<<EOS
    <div class="footer">

    </div>
    EOS;

    return $html;
}

function displayViewToNotLogged(){
    $html = "<section class='default'>";
    $html .=<<<EOS
    <h1 class="texto_infor"> No estas loguead@ para ver tu música</h1>
    EOS;

    return $html;
}