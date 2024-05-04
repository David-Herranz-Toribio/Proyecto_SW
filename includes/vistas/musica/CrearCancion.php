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
    $form = new FormularioCrearCancion();
    $content = $form->gestiona();
}


require_once LAYOUT_URL;