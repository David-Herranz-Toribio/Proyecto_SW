<?php 

require_once "../Config.php";
require_once CLASSES_URL . '/Cancion.php';
require_once CLASSES_URL . '/Usuario.php';

$id = $_POST['likeId'];
$user = null;
if(isset($_SESSION['username']))
    $user = $_SESSION['username'];

//Log usear or ask again for his account
if($user){
    //añadir like BD
    $aux = 1;
    $cancion = SW\classes\Cancion::obtenerCancionPorID($id);
    
    if($cancion->likeAsignado($id,$user)){
        $aux = -1;
        SW\classes\Cancion::borraFav($cancion, $user);
    }else
    SW\classes\Cancion::insertaFav($cancion, $user);
    
    $autorCancion = SW\classes\Usuario::buscaUsuario($cancion->getIdArtista());
    $autorCancion->aumentaKarma($aux);
    $autorCancion->actualiza();
    $cancion->aumentaLikes($aux);
    //SW\classes\Post::actualizar($post);

    //Insertar en la playlist de favs la cancion 


}

header('Location: ' . VIEWS_PATH . '/foro/Foro.php');
exit();