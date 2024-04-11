<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/SignUpHelper.php';

$errors = generateErrorMessages();
$form = generateFormularyArtist($errors);

$content =<<<EOS
    <section class='formulario_style'> 
    $form
    </section> 
EOS; 

require_once LAYOUT_URL; 