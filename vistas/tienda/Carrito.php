<?php

require_once '../../Config.php';
require_once RUTA_HELPERS.'/TiendaHelper.php';

$user = null;

$content = "<h2>No estas registrado</h2>";

if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $content = showCarrito($user);
}

require_once RUTA_LAYOUTS;