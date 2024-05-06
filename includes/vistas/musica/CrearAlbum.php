<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/CrearAlbumHelper.php';


$username = '';
$content = '';

if(!isset($_GET['user']) || !isset($_SESSION['username']) || $_GET['user'] !== $_SESSION['username']){
    $content = displayMessage("No tienes permiso para realizar esta acción");
}
else{
    $username = htmlspecialchars($_GET['user'], ENT_QUOTES);
    $content = displayFormulario($username);
}

require_once LAYOUT_URL;