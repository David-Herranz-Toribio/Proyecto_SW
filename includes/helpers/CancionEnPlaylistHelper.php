<?php
require_once '../../Config.php';
require_once CLASSES_URL . '/Playlist.php';
require_once CLASSES_URL . '/FormularioAddCancion_Playlist.php';


function displayErrorMessage($message){

    $html =<<<EOS
    <div class="playlistNotFound">
        <h2> $message </h2>
    </div>
    EOS;

    return $html;
}

function displayHeader(){
    
    $html =<<<EOS
    <h2 class='texto_infor'> Añadir canción a playlist </h2>
    EOS;

    return $html;
}

function displayPlaylistsToAdd($username, $idCancion){

    $playlists = SW\classes\Playlist::obtenerPlaylistsBD($username);
    if(count($playlists) <= 1){
        return displayErrorMessage("No tienes playlists creadas para añadir una canción");
    }

    $html = displayHeader();
    $form = new FormularioAddCancion_Playlist($idCancion, $playlists);
    $html .= $form->gestiona();

    return $html;
}