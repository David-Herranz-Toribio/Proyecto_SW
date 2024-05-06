<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioRegistro.php'; 

$form= new FormularioRegistro(true); 
$htmlform= $form->gestiona(); 

$content= <<<EOS
    <section class= 'formulario_style'> 
    $htmlform
    </section> 
EOS; 

require_once LAYOUT_URL; 
