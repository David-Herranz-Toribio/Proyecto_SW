<?php 

require_once '../../Config.php';
require_once CLASSES_URL .'/FormularioLogin.php'; 


// Barra de búsqueda para usuarios seguidos y seguidores
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$top_message=<<<EOS
<p> 2Music ¡Música sin limites para perder el tiempo! </p>
EOS; 

$form = new FormularioLogin(); 
$htmlform = $form->gestiona(); 

$content =<<<EOS
    <section class='formulario_style'> 
    $top_message
    $htmlform
    </section> 
EOS; 

require_once LAYOUT_URL;