<?php
require_once '../../Config.php';

function showViewToNotLogged(){
    
    $html =<<<EOS
    <h1 class="texto_infor"> No estas loguead@ </h1>
    EOS;

    return $html;
}

function showPlaylists($username){
    
    // Obtener las playlists del usuario
    if(0)
        $playlists = \es\ucm\fdi\aw\Playlist::obtenerPlaylistsBD($username);

    // Mostrar header de las playlists
    $html = showHeader();

    if(1){
        $html .= TEST();

        return $html;
    }

    // Mostrar todas las playlists
    foreach($playlists as $list){
        $html .= showPlaylist($list);
    }

    // Mostrar artistas que sigues
    $html .= showFollowingArtists($username);

    return $html;
}

function TEST(){

    // Boton para crear playlists
    $html =<<<EOS
    <div class="musicButtons">
        <form action="PlaylistView.php" method="get">
            <button> Crear playlist </button>
        </form>
    </div>
    EOS;

    // Mostrar todas las playlists del usuario
    $html .=<<<EOS
    <section class="musicList">

        <!-- Playlist 1 -->
        <article class="music_playlist">
            <div class="music_playlist_image">
                <img src="../../../img/songImages/portada1.jpg" alt="Portada de la playlist">
            </div>

            <div class="music_playlist_info">
                <a href="PlaylistView.php"><h2> Nombre de la playlist 1 </h2></a>
                <p> Número de canciones </p>
            </div>
        </article>

        <!-- Playlist 2 -->
        <article class="music_playlist">
            <div class="music_playlist_image">
                <img src="../../../img/songImages/portada1.jpg" alt="Portada de la playlist">
            </div>

            <div class="music_playlist_info">
                <a href="PlaylistView.php"><h2> Nombre de la playlist 2 </h2></a>
                <p> Número de canciones </p>
            </div>
        </article>

        <!-- Playlist 3 -->
        <article class="music_playlist">
            <div class="music_playlist_image">
                <img src="../../../img/songImages/portada1.jpg" alt="Portada de la playlist">
            </div>

            <div class="music_playlist_info">
                <a href="PlaylistView.php"><h2> Nombre de la playlist 3 </h2></a>
                <p> Número de canciones </p>
            </div>
        </article>

        <!-- Playlist 4 -->
        <article class="music_playlist">
            <div class="music_playlist_image">
                <img src="../../../img/songImages/portada1.jpg" alt="Portada de la playlist">
            </div>

            <div class="music_playlist_info">
                <a href="PlaylistView.php"><h2> Nombre de la playlist 4 </h2></a>
                <p> Número de canciones </p>
            </div>
        </article>

    </section>
    EOS;

    return $html;
}

function showHeader(){

    $html =<<<EOS
    <div class="musicHeader">
        <h1> Tu música </h1>
    </div>
    EOS;

    return $html;
}

function showPlaylist($playlist){

    $html =<<<EOS
    <div class="playlist">
        <div class="music_playlist_image">
            <img src="../../../img/songImages/portada1.jpg" alt="Portada de la playlist">
        </div>

        <div class="music_playlist_info">
            <div>
                <p> Nombre de la playlist1 </p>
                <p> Información de la playlist </p>
            </div>

            <div>
                <p> Número de canciones </p>
                <p> Duración total de la playlist </p>
            </div>
        </div>
    </div>
    EOS;

    return $html;
}

function showFollowingArtists($username){

    // Mostrar los artistas a los que el usuario sigue
    // Imagen del artista, nombre y link a su perfil
}

function showFooter(){

    $html =<<<EOS
    <div class="footer">

    </div>
    EOS;

    return $html;
}