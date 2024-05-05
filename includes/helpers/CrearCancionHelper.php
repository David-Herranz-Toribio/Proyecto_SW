<?php

function displayMessage($message){

    $html =<<<EOS
    <h2 class='text_infor'> $message </h2>
    EOS;

    return $html;
}

function displayFormulario($form){

    $html =<<<EOS
    <div class='texto_infor'>
        <h2> Subir canción </h2>
    </div>
    EOS;

    $html .=<<<EOS
    <section class='crearCancionForm'>
    <fieldset>
        <legend> Datos </legend>
        $form
    </fieldset>
    </section>
    EOS;

    return $html;
}