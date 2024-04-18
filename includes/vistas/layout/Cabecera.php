<?php

require_once HELPERS_URL . '/CabeceraSesion.php';

$currentPage = $_SERVER['REQUEST_URI'];

echo generateStaticHeader($currentPage);