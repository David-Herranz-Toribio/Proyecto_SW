<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;

if($yo){
    $content = "<h1 class='texto_infor'> Productos </h1>";
    $content .= showProducts($yo);
}
else
    $content = "<h1 class='texto_infor'> No estas loguead@ </h1>";

require_once LAYOUT_URL;