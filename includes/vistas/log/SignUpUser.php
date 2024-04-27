<?php
require_once '../../Config.php';
require_once CLASSES_URL .'/FormularioRegistro.php'; 

$form= new FormularioRegistro();  

$htmlform= $form->gestiona(); 

$content=<<<EOS
<section class= "formulario_style"> 
$htmlform
</section> 
EOS; 

require_once LAYOUT_URL; 

/*
require_once '../../Config.php';
require_once HELPERS_URL . '/SignUpHelper.php';

$errors = generateErrorMessages();
$form = generateFormularyUser($errors);
$artist_link = generateArtistAccountLink();

$content =<<<EOS
    <section class='formulario_style'> 
    $form
    $artist_link
    </section> 
EOS; 
*/