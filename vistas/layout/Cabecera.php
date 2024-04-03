<?php

require_once RUTA_HELPERS.'/CabeceraSesion.php';

$currentPage = $_SERVER['REQUEST_URI'];

echo generateStaticHeader($currentPage);