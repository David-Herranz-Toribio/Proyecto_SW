<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$user = null;
$content = "<section class='default'>";

if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $content .= showCarrito($user);
}
else {
    header('Location:'. VIEWS_PATH . '/log/Login.php');
    exit(); 
}

require_once LAYOUT_URL;