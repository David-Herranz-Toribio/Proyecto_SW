<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/FavoritosHelper.php';

$username = $_POST['user'];
$favs = $_POST['favs'];

$content = mostrarFavoritos($username, $favs);

require_once LAYOUT_URL;