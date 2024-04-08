<?php

require_once '../../../Config.php';
require_once HELPERS_URL . '/SignUpHelper.php';

$imgUser = generateUserImage();
$errors = generateErrorMessages();
$form = generateFormularyArtist($errors);

$content =<<<EOS
    <section class='formulario_style'> 
    $imgUser
    $form
    </section> 
EOS; 

require_once LAYOUT_URL; 