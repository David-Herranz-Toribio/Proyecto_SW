<?php 

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';

$id = $_POST['EliminarID'];
$user = null;

if(isset($_SESSION['username']))
    $user = $_SESSION['username'];

$isValid = true;

if($isValid && $user){
    $post = Post::buscarPostPorID($id);
    Post::borrarPost($post);
}

header('Location:'. VIEWS_URL .'/foro/Foro.php');
exit();