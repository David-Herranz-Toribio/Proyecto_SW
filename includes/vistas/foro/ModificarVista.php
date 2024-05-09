<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/FormularioPost.php'; 


// Selección de barra d búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();
$topSearchBar->notDisplaySearchBar();

$form = new FormularioPost( $_POST['idPadre'],$_POST['idPost']); 
$htmlform = $form->gestiona(); 
$content = <<<EOS
    <section class= 'formulario_style'> 
    $htmlform
    </section> 
EOS; 

/*$content = modificatePost($post->getTexto(), $post->getId());*/

require_once LAYOUT_URL;