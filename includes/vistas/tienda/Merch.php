<?php

require_once '../../Config.php';
require_once HELPERS_PATH . '/TiendaHelper.php';

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;

$content = showProducts($yo);

require_once LAYOUT_PATH;