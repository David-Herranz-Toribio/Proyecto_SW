<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';


// Selección de barra d búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarProductos();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$id_prod = isset($_GET['ModificarID']) ? $_GET['ModificarID'] : null;
if(isset($_SESSION['isArtist']) && $_SESSION['isArtist']){
    $content = addProd($yo, $id_prod);
    $content .= showProductsArtista($yo);
}else{
    header('Location:'. VIEWS_PATH .'/tienda/Merch.php');
    exit();
}


require_once LAYOUT_URL;