<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioRegistro.php'; 


// Barra de búsqueda para usuarios seguidos y seguidores
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$form = new FormularioRegistro(true); 
$htmlform= $form->gestiona(); 

$content= <<<EOS
    <section class= 'formulario_style'> 
    $htmlform
    </section> 
EOS; 

require_once LAYOUT_URL; 
