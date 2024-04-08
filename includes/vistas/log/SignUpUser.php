<?php

require_once '../../../Config.php';
require_once HELPERS_URL . '/SignUpHelper.php';

$imgUser = generateUserImage();
$errors = generateErrorMessages();
$form = generateFormularyUser($errors);
$artist_link = generateArtistAccountLink();

$content =<<<EOS
    <section class='formulario_style'> 
    $imgUser
    $form
    $artist_link
    </section> 
EOS; 

require_once LAYOUT_URL; 