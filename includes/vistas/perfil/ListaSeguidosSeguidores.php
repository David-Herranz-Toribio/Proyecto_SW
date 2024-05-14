<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/UsuariosHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$usuario = filter_var($_GET["user"] ?? $_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$opcion = filter_var($_GET['opcion'] ?? NULL, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$user = SW\classes\Usuario::buscaUsuario($usuario);
$content = showUsers($user, $opcion);

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;

