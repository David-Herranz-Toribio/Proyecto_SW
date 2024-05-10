<?php
    require_once '../Config.php'; 
    require_once CLASSES_URL . "/Cancion.php"; 

    $idPlayList= $_GET['idPlaylist']; 

    $canciones= SW\classes\Cancion:: getSongsFromPlaylistID($idPlayList); 
    $i= 0; 
    foreach($canciones as $cancion_act){
        $x[$i]= array(AUDIO_PATH . '/' .$cancion_act->getCancionRuta(), $cancion_act->getCancionTitulo()); 
        $i++; 
    }


    header('Content-Type: application/json');
    echo json_encode($x); 



?> 