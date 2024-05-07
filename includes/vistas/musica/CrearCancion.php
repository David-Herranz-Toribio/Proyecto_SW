<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioCrearCancion.php';
require_once HELPERS_URL . '/CrearCancionHelper.php';

$content = '';
if(!isset($_SESSION['username'])){
    $content = displayMessage("Debes estar logead@ para crear una canción");
}
else{

    // Formulario para poder subir una canción
    $form = new FormularioCrearCancion($_SESSION['username']);
    $htmlform = $form->gestiona();

    $head =<<<EOS
    <div class='texto_infor'>
        <h2> Subir canción </h2>
    </div>
    EOS;

    $content =<<<EOS
    $head
    <section class='formulario_style'>
    $htmlform
    </section>
    EOS;

}


require_once LAYOUT_URL;