<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/UsuariosHelper.php';

$usuario = $_GET["user"] ?? $_SESSION['username'];
$opcion = $_GET['opcion'] ?? NULL;
$user = SW\classes\Usuario::buscaUsuario($usuario);
$content = showUsers($user, $opcion);
require_once LAYOUT_URL;
