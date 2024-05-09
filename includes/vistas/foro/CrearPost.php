<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/FormularioPost.php';


// Barra de búsqueda para usuarios seguidos y seguidores
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

if(isset($_POST['id_padre'])) 
    $id_padre = $_POST['id_padre']; 
else 
    $id_padre = NULL; 


$form = new FormularioPost($id_padre, null); 
$htmlform = $form->gestiona(); 

$content= <<<EOS
<section class= 'formulario_style'> 
$htmlform
</section> 
EOS; 

require_once LAYOUT_URL;  