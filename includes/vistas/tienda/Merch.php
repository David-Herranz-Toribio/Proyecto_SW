<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarProductos();

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$content = "<section class='default'>";
if($yo){
    $content .= "<h1 class='texto_infor'> Productos </h1>";
    $content .= showProducts($yo);
}
else {
    $content .=<<<EOS
    <h1 class='texto_infor'> No estas loguead@ para ver la tienda</h1>
    EOS;
}

require_once LAYOUT_URL;