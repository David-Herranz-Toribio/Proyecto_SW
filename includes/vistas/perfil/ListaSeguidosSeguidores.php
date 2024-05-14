<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/UsuariosHelper.php';


// Selección de barra de búsqueda y visibilidad
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->notDisplaySearchBar();

$usuario = $_GET["user"] ?? $_SESSION['username'];
$opcion = $_GET['opcion'] ?? NULL;
$user = SW\classes\Usuario::buscaUsuario($usuario);
$content = showUsers($user, $opcion);

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;
