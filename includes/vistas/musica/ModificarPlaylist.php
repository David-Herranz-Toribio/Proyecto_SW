<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/FormularioPlaylist.php'; 

// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$idPlaylist= filter_var($_POST['idPlaylist'], FILTER_SANITIZE_NUMBER_INT); 

$artista= filter_var($_POST['idCreador'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 


$form = new FormularioPlaylist($artista ,$idPlaylist); 
$htmlform = $form->gestiona(); 
$content = <<<EOS
    <section class= 'formulario_style'> 
    $htmlform
    </section> 
EOS; 

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;  