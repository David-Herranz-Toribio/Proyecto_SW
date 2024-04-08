<?php

require_once '../../Config.php';
require_once RUTA_HELPERS.'/TiendaHelper.php';

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$prod = $_GET["prod"] ?? NULL;

$content = showProduct($yo, $prod);

require_once RUTA_LAYOUTS;