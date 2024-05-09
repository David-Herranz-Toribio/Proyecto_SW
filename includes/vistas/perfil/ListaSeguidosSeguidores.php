<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/UsuariosHelper.php';


// Selección de barra d búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarSeguidoresSeguidos();

$usuario = $_GET["user"] ?? $_SESSION['username'];
$opcion = $_GET['opcion'] ?? NULL;
$user = SW\classes\Usuario::buscaUsuario($usuario);
$content = "<section class='default'>";
$content .= showUsers($user, $opcion);
require_once LAYOUT_URL;
