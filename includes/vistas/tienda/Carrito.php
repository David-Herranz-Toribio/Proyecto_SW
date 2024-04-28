<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';

$user = null;

$content = "<h1 class='texto_infor'> No estas loguead@ </h1>";


if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $content = showCarrito($user);
}

require_once LAYOUT_URL;