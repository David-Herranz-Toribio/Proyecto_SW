<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';

$user = null;
$content = "<section class='default'>";
$content .=<<<EOS
    <h1 class='texto_infor'> No estas loguead@ para ver tu carrito </h1>
EOS;


if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $content = showCarrito($user);
}

require_once LAYOUT_URL;