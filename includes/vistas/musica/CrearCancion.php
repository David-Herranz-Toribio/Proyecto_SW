<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioCrearCancion.php';
require_once HELPERS_URL . '/CrearCancionHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

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
    $form = new FormularioCrearCancion($_SESSION['username'], $playlist);
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

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;