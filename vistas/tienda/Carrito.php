<?php

require_once '../../Config.php';
require_once RUTA_HELPERS.'/TiendaHelper.php';

$user = null;

if(isset($_SESSION['username']))
    $user = $_SESSION['username'];

$content = showCarrito($user);

require_once RUTA_LAYOUTS;