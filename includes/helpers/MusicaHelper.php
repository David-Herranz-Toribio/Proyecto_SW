<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Playlist.php';
require_once CLASSES_URL . '/Cancion.php';
require_once CLASSES_URL . '/Usuario.php';
require_once CLASSES_URL . '/FormularioPlaylist.php'; 

function showPlaylists($username){
    
    // Obtener las playlists del usuario
    $playlists = SW\classes\Playlist::obtenerPlaylistsBD($username);

    // Mostrar header de las playlists
    $html = displayHeader();

    // Mostrar botones
    $html .= displayButtonsPlaylist($username);

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

function displayButtonsPlaylist($username){

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
    $view_path = VIEWS_PATH . '/musica/PlaylistView.php';

    $html =<<<EOS
    <article class="music_playlist">
        <div class="music_playlist_image">
            <img src="$image" alt="Portada de la playlist">
        </div>

        <div class="music_playlist_info">
            <a href="$view_path?id=$id"><h2> $nombre </h2></a>
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


function displayMusicStyle($cancion){
    
    $idCancion = $cancion->getIdCancion();
    $rutaLike = HELPERS_PATH . '/ProcesarLikeCancion.php';
    $playButton = IMG_PATH . '/play_button.png';
    $optionsButton = IMG_PATH . '/options_button.png';
    $rutaVistaArtista= VIEWS_PATH. '/perfil/Perfil.php?user=' . $cancion->getIdArtista();
    $rutaVistaCancion = VIEWS_PATH . '/musica/CancionVista.php?id_cancion=' . $idCancion;
    $addSongPath = VIEWS_PATH . '/musica/CancionEnPlaylist.php';
    
    $html =<<<EOS
    <div class='album_song'>
        <div class='songName'>
            <p> <a href= $rutaVistaCancion > {$cancion->getCancionTitulo()} </a>  </p>
            <p> <a href= $rutaVistaArtista > {$cancion->getIdArtista()} </a> </p>
        </div>

        <div class='songDate'>
            <p> {$cancion->getCancionFecha()} </p>
        </div>

        <div class='songLikes'>
            <p> {$cancion->getCancionLikes()} &#9834 </p>
            <form action=$rutaLike method="post">
            <input type="hidden" name="likeId" value="$idCancion">
            <button class type="submit"> &#9834 </button>
            </form>
        </div>

        <div class='songButtons'>
            <button class='playButton' id='playSong' ><img src=$playButton></button>
            <span hidden> {$cancion->getCancionRuta()} </span> 
            <a class='optionsButton' href=$addSongPath?song=$idCancion><img src=$optionsButton></a>
        </div>
    </div>
    EOS;

    return $html; 
}