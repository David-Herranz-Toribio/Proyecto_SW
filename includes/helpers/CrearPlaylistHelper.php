<?php

require_once '../../Config.php';
require_once FORMS_URL . '/FormularioCrearPlaylist.php';

function displayFormulario($username){

    $form = new FormularioCrearPlaylist($username);
    $formHTML = $form->gestiona();

    $html =<<<EOS
    <section class="createPlaylistForm">
        $formHTML
    </section>
    EOS;

    return $html;
}

function displayMessage($message){

    $html =<<<EOS
    <h2 class='text_infor'> $message </h2>
    EOS;

    return $html;
}