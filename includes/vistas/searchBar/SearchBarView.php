<?php
require_once '../../Config.php';
require_once HELPERS_URL . '/SearchBarHelper.php';


$data = isset($_GET['data']) ? filter_var($_GET['data'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$table = $_GET['table'] ?? '';
$filters = $_GET['filters'] ?? '';
$content = searchQuery($table, $filters, $data);

require_once LAYOUT_URL;