<?php 

require_once "../Config.php";
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/Usuario.php';

$id = $_POST['likeId'];
$user = null;
if(isset($_SESSION['username']))
    $user = $_SESSION['username'];

//Log usear or ask again for his account
if($user){
    //añadir like BD
    $aux = 1;
    $post = SW\classes\Post::buscarPostPorID($id);
    
    if(SW\classes\Post::likeAsignado($id,$user)){
        $aux = -1;
        SW\classes\Post::borraFav($post, $user);
    }else
    SW\classes\Post::insertaFav($post, $user);
    
    $usuario = SW\classes\Usuario::buscaUsuario($post->getAutor());
    $usuario->aumentaKarma($aux);
    $usuario->actualiza();
    $post->aumentaLikes($aux);
    SW\classes\Post::actualizar($post);
}

header('Location: ' . VIEWS_PATH . '/foro/Foro.php');
exit();