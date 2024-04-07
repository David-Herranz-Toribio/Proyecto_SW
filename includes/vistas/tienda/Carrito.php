<?php

require_once '../../Config.php';
require_once HELPERS_PATH . '/TiendaHelper.php';

$user = null;

$content = "<h2>No estas registrado</h2>";

if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $content = showCarrito($user);
}

require_once LAYOUT_PATH;