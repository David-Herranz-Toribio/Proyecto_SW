<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioCancion.php';
require_once HELPERS_URL . '/CrearCancionHelper.php';

$content = '';
if(!isset($_SESSION['username'])){
    $content = displayMessage("Debes estar logead@ para crear una canción");
}
else{

    // Formulario para poder subir una canción
    $form = new FormularioCancion($_SESSION['username'], null);
    $htmlform = $form->gestiona();

    $content =<<<EOS
    <section class='formulario_style'>
    $htmlform
    </section>
    EOS;

}


require_once LAYOUT_URL;