<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';

$user = null;
$content = '';

if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $content = showCarrito($user);
}
else {
    $content =<<<EOS
    <h1 class='texto_infor'> No estas loguead@ para ver tu carrito </h1>
    EOS;
}

require_once LAYOUT_URL;