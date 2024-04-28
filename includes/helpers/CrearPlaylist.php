<?php

require_once '../Config.php';
require_once CLASSES_URL . '/Playlist.php';

$imagen = isset($_POST['imagen']) && $_POST['imagen'] ? $_POST['imagen'] : IMG_PATH . '/profileImages/FotoPerfil.png';
$nombre = $_POST['nombre'];
$creationDate = new DateTime();
$creationDate = $creationDate->format('Y-m-d');

// Crear playlist en la base de datos
$done = SW\classes\Playlist::crearPlaylistBD($_SESSION['username'], $nombre, $imagen, $creationDate);
if(!$done){

    $content =<<<EOS
    <div class="creatingPlaylistError">
        <h2> Ocurrió un error creando la playlist </h2>
    </div>
    EOS;

    require_once LAYOUT_URL;
    exit();
}

header('Location: ' . VIEWS_PATH . '/musica/Musica.php');
exit();