<?php
require_once '../../Config.php';
require_once HELPERS_URL . '/SearchBarHelper.php';


$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$data = isset($_GET['data']) ? filter_var($_GET['data'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$opcion = isset($_GET['searchOption']) ? filter_var($_GET['searchOption'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$content = searchQuery($data, $opcion);
if(!$content)
    $content = displayMessage("No se han encontrado resultados");

if($opcion === \SW\classes\TopSearchBar::$CANCIONES){
    $scripts = ['playerLogic.js', 'desplegable.js', 'confirmacion.js'];
}

require_once LAYOUT_URL;