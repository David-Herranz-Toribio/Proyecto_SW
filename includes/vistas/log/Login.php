<?php 

require_once '../../Config.php';
require_once FORMS_URL .'/FormularioLogin.php'; 

$top_message =<<<EOS
<p> 2Music ¡Música sin limites para perder el tiempo! </p>
EOS; 

$form = new FormularioLogin(); 
$htmlform = $form->gestiona(); 

$content =<<<EOS
    <section class='formulario_style'> 
    $top_message
    $htmlform
    </section> 
EOS; 

require_once LAYOUT_URL;