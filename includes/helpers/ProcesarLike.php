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
    $post = es\ucm\fdi\aw\Post::buscarPostPorID($id);
    
    if(es\ucm\fdi\aw\Post::likeAsignado($id,$user)){
        $aux = -1;
        es\ucm\fdi\aw\Post::borraFav($post, $user);
    }else
    es\ucm\fdi\aw\Post::insertaFav($post, $user);
    
    $usuario = es\ucm\fdi\aw\Usuario::buscaUsuario($post->getAutor());
    $usuario->aumentaKarma($aux);
    $usuario->actualiza();
    $post->aumentaLikes($aux);
    es\ucm\fdi\aw\Post::actualizar($post);
}

header('Location: ' . VIEWS_PATH . '/foro/Foro.php');
exit();