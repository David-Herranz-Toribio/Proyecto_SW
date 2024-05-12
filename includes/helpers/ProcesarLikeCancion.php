<?php 

require_once "../Config.php";
require_once CLASSES_URL . '/Cancion.php';
require_once CLASSES_URL . '/Usuario.php';
require_once CLASSES_URL . '/Playlist.php'; 

$id = $_POST['likeId'];
$user = null;
if(isset($_SESSION['username']))
    $user = $_SESSION['username'];

//Log usear or ask again for his account
if($user){
    //añadir like BD
    $aux = 1;
    $cancion = SW\classes\Cancion::obtenerCancionPorID($id);
    
    $borrarLike= $cancion->likeAsignado($id,$user); 


    if($borrarLike){
        $aux = -1;
        SW\classes\Cancion::borraFav($cancion, $user);
    }else
    SW\classes\Cancion::insertaFav($cancion, $user);
    
    $autorCancion = SW\classes\Usuario::buscaUsuario($cancion->getIdArtista());
    $autorCancion->aumentaKarma($aux);
    $autorCancion->actualiza();
    $cancion->aumentaLikes($aux);
    SW\classes\Cancion::actualizar($cancion);

    //Insertar en la playlist de favs la cancion 

    $playlist= SW\classes\Playlist::obtenerPlaylistFav("Favoritos", filter_var($_SESSION['username'])); 
    if($borrarLike){
        $playlist->quitarCancion($id); 
    }
    else $playlist->addCancion($id); 
}

header('Location: ' . VIEWS_PATH . '/foro/Foro.php');
exit();