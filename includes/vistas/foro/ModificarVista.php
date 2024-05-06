<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once FORMS_URL . '/FormularioModificacionPost.php'; 

$form = new FormularioModificacionPost($_POST['ModificarID']); 
$htmlform = $form->gestiona(); 


$content =<<<EOS
    <section class= 'formulario_style'> 
    $htmlform
    </section> 
EOS; 

/*$content = modificatePost($post->getTexto(), $post->getId());*/

require_once LAYOUT_URL;