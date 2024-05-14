<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarProductos();

$yo = isset($_SESSION['username']) ? filter_var($_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
$id_prod = isset($_GET['ModificarID']) ? filter_var($_GET['ModificarID'], FILTER_VALIDATE_INT) : null;
if(isset($_SESSION['isArtist']) && $_SESSION['isArtist']){
    $content = addProd($yo, $id_prod);
    $content .= showProductsArtista($yo);
}else{
    header('Location:'. VIEWS_PATH .'/tienda/Merch.php');
    exit();
}

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;