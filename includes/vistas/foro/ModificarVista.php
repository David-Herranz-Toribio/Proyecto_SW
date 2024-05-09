<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/FormularioPost.php'; 


// Barra de búsqueda para usuarios seguidos y seguidores
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$form = new FormularioPost( $_POST['idPadre'],$_POST['idPost']); 
$htmlform = $form->gestiona(); 
$content = <<<EOS
    <section class= 'formulario_style'> 
    $htmlform
    </section> 
EOS; 

/*$content = modificatePost($post->getTexto(), $post->getId());*/

require_once LAYOUT_URL;