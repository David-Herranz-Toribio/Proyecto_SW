<?php

require_once '../../Config.php';
require_once RUTA_HELPERS.'/TiendaHelper.php';

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;

$content = showProducts($yo);

require_once RUTA_LAYOUTS;