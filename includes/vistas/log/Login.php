<?php 

require_once '../../Config.php';
require_once HELPERS_URL . '/LoginHelper.php';

global $isArtist;

$message = generateHeader();
$formulario = generateFormulary();
$errores = generateErrorMessages();

$content = "<section class='default'>";
$content .=<<<EOS
    <section class='formulario_style'> 
    $message
    $formulario
    $errores
    </section> 
EOS;
    
require_once LAYOUT_URL;