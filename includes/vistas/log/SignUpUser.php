<?php
require_once '../../Config.php';
require_once CLASSES_URL .'/FormularioRegistro.php'; 


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$form = new FormularioRegistro(false);  

$htmlform= $form->gestiona(); 

$content=<<<EOS
<section class= "formulario_style"> 
$htmlform
</section> 
EOS; 
$scripts= ['eventos.js']; 

require_once LAYOUT_URL; 