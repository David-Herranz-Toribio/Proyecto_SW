<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/PostHelper.php';


// Barra de búsqueda para usuarios seguidos y seguidores
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$id_post = $_POST["respuestasId"] ?? NULL;
$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$content = showResp($id_post, $yo);

require_once LAYOUT_URL;