<?php
require_once '../../Config.php';
require_once HELPERS_URL . '/CancionEnPlaylistHelper.php';


$id_cancion = '';
if(isset($_GET['song']))
    $id_cancion = filter_var($_GET['song'], FILTER_VALIDATE_INT);

$username = '';
if(isset($_SESSION['username']))
    $username = $_SESSION['username'];

$content = '';
if($id_cancion == ''){
    $content = displayErrorMessage("No se ha encontrado la canción");
}
else{
    $content = displayPlaylistsToAdd($username, $id_cancion);
}

$scripts = ['confirmacion.js']; 
require_once LAYOUT_URL;
