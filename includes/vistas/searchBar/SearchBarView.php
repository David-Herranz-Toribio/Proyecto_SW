<?php
require_once '../../Config.php';
require_once HELPERS_URL . '/SearchBarHelper.php';


$data = isset($_GET['data']) ? filter_var($_GET['data'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$opcion = isset($_GET['searchOption']) ? filter_var($_GET['searchOption'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$content = searchQuery($data, $opcion);

require_once LAYOUT_URL;