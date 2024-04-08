<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$prod = $_GET["prod"] ?? NULL;

$content = showProducts($yo, $prod);

require_once LAYOUT_URL;