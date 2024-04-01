<?php 

require_once '../../Config.php';
require_once RUTA_HELPERS . '/LoginHelper.php';

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
    
require_once RUTA_LAYOUTS;