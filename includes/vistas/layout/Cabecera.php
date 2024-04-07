<?php

require_once HELPERS_PATH . '/CabeceraSesion.php';

$currentPage = $_SERVER['REQUEST_URI'];

echo generateStaticHeader($currentPage);