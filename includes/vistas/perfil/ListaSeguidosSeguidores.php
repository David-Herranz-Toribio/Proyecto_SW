<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/UsuariosHelper.php';


// Barra de búsqueda para usuarios seguidos y seguidores
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

$usuario = $_GET["user"] ?? $_SESSION['username'];
$opcion = $_GET['opcion'] ?? NULL;
$user = SW\classes\Usuario::buscaUsuario($usuario);
$content = "<section class='default'>";
$content .= showUsers($user, $opcion);
require_once LAYOUT_URL;
