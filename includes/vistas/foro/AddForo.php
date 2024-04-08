<?php

require_once '../../../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/Usuario.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : false;
$post_text = isset($_POST['post_text']) ? htmlspecialchars($_POST['post_text']) : false;  

if ($_FILES['image']['name'] != ''){
    $archivo_nombre = $_FILES['image']['name'];
    $archivo_tipo = $_FILES['image']['type'];
    $archivo_tamaño = $_FILES['image']['size'];
    $archivo_temporal = $_FILES['image']['tmp_name'];

    $directorio_destino = IMG_PATH . '/postImages/';

    //Nombre con extension
    $ultimo_punto = strrpos($archivo_nombre, '.');
    $extension = substr($archivo_nombre, $ultimo_punto + 1);
    $post_image = uniqid() . '.' . $extension;

    //Ruta de guardado
    $ruta_destino = $directorio_destino . $post_image;
    move_uploaded_file($archivo_temporal, $ruta_destino);
}
else
    $post_image = false;

if($_POST['id_padre'] != "") $post_father= $_POST['id_padre']; 
else $post_father = 'NULL'; 

$user = Usuario::buscaUsuario($username);
$post = $user->publicarPost($post_text, $post_image, $post_father);

header('Location:'. VIEWS_URL .'/foro/Foro.php'); 
exit(); 