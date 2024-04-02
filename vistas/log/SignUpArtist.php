<?php

require_once '../../Config.php';
require_once RUTA_HELPERS . '/SignUpHelper.php';

$imgUser = generateUserImage();
$form = generateFormularyArtist();
$errors = generateErrorMessages();

$content =<<<EOS
    <section class= 'formulario_style'> 
    $imgUser
    $form
    $errors
    </section> 
EOS; 

require_once RUTA_LAYOUTS; 