<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/FavoritosHelper.php';

$username = $_GET['username'];
$favs = $_GET['favs'];

$content = mostrarFavoritos($username, $favs);

require_once LAYOUT_URL;