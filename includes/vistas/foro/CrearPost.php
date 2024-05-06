<?php

require_once '../../Config.php';
require_once FORMS_URL . '/FormularioPost.php'; 


if(isset($_POST['id_padre'])) 
    $id_padre = $_POST['id_padre']; 
else 
    $id_padre = NULL; 


$form = new FormularioPost($id_padre); 
$htmlform = $form->gestiona(); 

$content = <<<EOS
<section class= 'formulario_style'> 
$htmlform
</section> 
EOS; 

require_once LAYOUT_URL;  