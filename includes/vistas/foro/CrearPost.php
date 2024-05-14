<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioPost.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$id_padre = isset($_POST['id_padre']) ? filter_var($_POST['id_padre'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

$form = new FormularioPost($id_padre, null); 
$htmlform = $form->gestiona(); 

$content = <<<EOS
<section class ='formulario_style'> 
$htmlform
</section> 
EOS; 

$scripts = ['confirmacion.js']; 

require_once LAYOUT_URL;  