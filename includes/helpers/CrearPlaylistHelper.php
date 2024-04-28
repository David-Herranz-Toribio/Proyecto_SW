<?php

require_once '../../Config.php';

function showCreatePlaylistView(){

    $defaulImage = IMG_PATH . '/profileImages/FotoPerfil.png';
    $procesarPath = HELPERS_PATH . '/CrearPlaylist.php';

    $html = "<section class='default'>";
    $html .=<<<EOS
    <section class="createPlaylistForm">
    <fieldset>
    <legend> Crear Playlist </legend>
    <form action=$procesarPath method="post">

        <div class="createPlaylistImage">
            <img src=$defaulImage alt="Imagen de la playlist">

            <div class="createPlaylistImageInput">
                <label> Imagen </label>
                <input name="imagen" type="file">
            </div>
        </div>

        <div class="createPlaylistConfig">
            <div class="createPlaylistName">
                <label> Nombre </label>
                <input name="nombre" type="text" required>
            </div>
        </div>

        <div>
            <button type="submit"> Crear </button>
        </div>
    </form>
    </fieldset>
    </section>
    EOS;

    return $html;
}