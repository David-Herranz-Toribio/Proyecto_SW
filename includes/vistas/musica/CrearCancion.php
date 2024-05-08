<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioCancion.php';
require_once HELPERS_URL . '/CrearCancionHelper.php';

$content = '';
if(!isset($_SESSION['username'])){
    $content = displayMessage("Debes estar logead@ para crear una canción");
}
else if(!isset($_GET['playlist'])){
    $content = displayMessage("Ocurrió algún problema...");
}
else{

    // Formulario para poder subir una canción
    $playlist = htmlspecialchars($_GET['playlist'], ENT_QUOTES);
    $form = new FormularioCancion($_SESSION['username'], null, $playlist);
    $htmlform = $form->gestiona();

    $content =<<<EOS
    <section class='formulario_style'>
    $htmlform
    </section>
    EOS;

}


require_once LAYOUT_URL;