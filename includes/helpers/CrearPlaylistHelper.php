<?php

function showCreatePlaylistView(){

    $html =<<<EOS
    <section class="createPlaylistForm">
    <fieldset>
    <legend> Crear Playlist </legend>
    <form>

        <div class="createPlaylistImage">
            <img src="../../../img/songImages/playlist1.jpg" alt="Imagen de la playlist">

            <div class="createPlaylistImageInput">
                <label> Imagen </label>
                <input type="file">
            </div>
        </div>

        <div class="createPlaylistConfig">
            <div class="createPlaylistName">
                <label> Nombre </label>
                <input type="text">
            </div>

            <div class="createPlaylistPrivacy">
                <label> Publica/Privada </label>
                <input type="text">
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