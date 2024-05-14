<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/PerfilHelper.php';

// Barra de búsqueda para usuarios
$topSearchBar = SW\classes\TopSearchBar::getInstance();
$topSearchBar->buscarUsuario();

// Obtenemos el username del perfil a visualizar (Otro usuario/Yo)
if(isset($_SESSION['username'])){
    $usuario = filter_var($_GET["user"] ?? $_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $opcion = filter_var($_GET['opcion'] ?? NULL, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user = SW\classes\Usuario::buscaUsuario($usuario);
    $content = showProfile($user, $opcion);
}

else{
    header('Location:'. VIEWS_PATH . '/log/Login.php');
    exit(); 
    $content = showNotLogged();
}

$scripts = ['playerLogic.js', 'desplegable.js', 'confirmacion.js']; 

require_once LAYOUT_URL;
