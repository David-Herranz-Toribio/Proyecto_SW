<?php 

require_once '../../Config.php';
require_once HELPERS_PATH . '/LoginHelper.php';

global $isArtist;

$message = generateHeader();
$formulario = generateFormulary();
$errores = generateErrorMessages();

$content =<<<EOS
    <section class='formulario_style'> 
    $message
    $formulario
    $errores
    </section> 
EOS;
    
require_once LAYOUT_PATH;