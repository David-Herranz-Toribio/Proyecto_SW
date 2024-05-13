<?php

require_once '../Config.php'; 
require_once CLASSES_URL . '/Playlist.php'; 


$id = filter_var($_POST['idPlaylist'], FILTER_VALIDATE_INT); 
if($id){
    $playlist = SW\classes\Playlist::obtenerPlaylistByID($id);
    $playlist->borrarPlaylist();
}

header('Location: ' . VIEWS_PATH . '/musica/Musica.php'); 
exit(); 
