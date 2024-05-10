<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/PerfilHelper.php';

// Barra de búsqueda para usuarios
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

// Obtenemos el username del perfil a visualizar (Otro usuario/Yo)
if(isset($_SESSION['username'])){

    $usuario = $_GET["user"] ?? $_SESSION['username'];
    $opcion = $_GET['opcion'] ?? NULL;
    $user = SW\classes\Usuario::buscaUsuario($usuario);
    $content = showProfile($user, $opcion);
}
else{
    $content = showNotLogged();
}

$scripts = ['playerLogic.js', 'desplegable.js']; 

require_once LAYOUT_URL;
