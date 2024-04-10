<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/PerfilHelper.php';

$usuario = '';
$favs = '';
$content = '';

// Obtenemos el username del perfil a visualizar (Otro usuario/Yo)
if(isset($_SESSION['username'])){
    $usuario = $_GET["user"] ?? $_SESSION['username'];
    $favs = $_GET["favs"] ?? NULL;
    $content = showProfile($usuario, $favs);
}
else{
    $content = showNotLogged();
}

require_once LAYOUT_URL;
