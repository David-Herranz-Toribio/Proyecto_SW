<?php 

require_once '../Config.php';
require_once CLASSES_URL . '/Post.php';
require_once CLASSES_URL . '/Usuario.php';

$id = $_POST['id'];
$tx = htmlspecialchars($_POST['postText']);

$post = Post::buscarPostPorID($id);
$post->setTexto($tx);
if ($_FILES['image']['name'] != ''){

    $archivo_nombre = $_FILES['image']['name'];
    $archivo_tipo = $_FILES['image']['type'];
    $archivo_tamaño = $_FILES['image']['size'];
    $archivo_temporal = $_FILES['image']['tmp_name'];

    $directorio_destino = IMG_URL . '/postImages/';

    //Nombre con extension
    $ultimo_punto = strrpos($archivo_nombre, '.');
    $extension = substr($archivo_nombre, $ultimo_punto + 1);
    $post_image = uniqid() . '.' . $extension;

    //Ruta de guardado
    $ruta_destino = $directorio_destino . $post_image;
    move_uploaded_file($archivo_temporal, $ruta_destino);
    // Eliminar archivo anterior si existe
    if (file_exists($directorio_destino . $post->getImagen()) && $post->getImagen() != 'FotoMerch.png') {
        unlink($directorio_destino . $post->getImagen());
    }
    $post->setImagen($post_image);
}

Post::actualizar($post);

header('Location:'. VIEWS_PATH .'/foro/Foro.php');
exit();