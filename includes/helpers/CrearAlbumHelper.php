<?php
require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioCrearAlbum.php';

function displayFormulario($username){

    $form = new FormularioCrearAlbum($username);
    $html =<<<EOS
    <section class='formCrearAlbum'>
        {$form->gestiona()}
    </section>
    EOS;

    return $html;
}

function displayMessage($message){

    $html =<<<EOS
    <h2 class='texto_infor'> $message </h2>
    EOS;

    return $html;
}