<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/FormularioPost.php'; 


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$form = new FormularioPost( $_POST['idPadre'],$_POST['idPost']); 
$htmlform = $form->gestiona(); 
$content = <<<EOS
    <section class= 'formulario_style'> 
    $htmlform
    </section> 
EOS; 

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;